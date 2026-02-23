/**
 * Propert-Ease RAG Chatbot
 * A lightweight RAG-based chatbot using TF-IDF retrieval + Google Gemini API.
 * Self-contained — no external dependencies required.
 */

(function () {
    'use strict';

    // ──────────────────────────── CONFIG ────────────────────────────
    const CONFIG = {
        apiKey: window.PROPERTEASE_GEMINI_KEY || '',
        models: ['gemini-2.5-flash-preview-05-20', 'gemini-2.5-flash'],  // available models for this API key
        knowledgeBasePath: null,       // auto-detected
        topK: 3,                       // chunks to retrieve
        maxHistory: 6,                 // conversation pairs to keep
        botName: 'Propert-Ease AI',
        welcomeMessage: "👋 Hi! I'm your **Propert-Ease** assistant. Ask me anything about society governance, compliance, billing, or our features!",
    };

    // ──────────────────────────── STATE ────────────────────────────
    let knowledgeBase = [];
    let chatHistory = [];
    let isOpen = false;
    let isTyping = false;
    let workingModel = CONFIG.models[0]; // track which model works

    // ──────────────────────────── UTILITIES ────────────────────────────

    /** Detect the base path for assets */
    function getBasePath() {
        const scripts = document.querySelectorAll('script[src*="chatbot.js"]');
        if (scripts.length > 0) {
            const src = scripts[0].getAttribute('src');
            return src.replace('chatbot.js', '');
        }
        // Fallback: check if we're in a subdirectory
        if (window.location.pathname.includes('/get-started/')) {
            return '../assets/js/';
        }
        return 'assets/js/';
    }

    /** Simple markdown-to-HTML for bot responses */
    function simpleMarkdown(text) {
        if (!text) return '';
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/`(.*?)`/g, '<code>$1</code>')
            .replace(/\n/g, '<br>');
    }

    /** Escape HTML to prevent XSS */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ──────────────────────────── TF-IDF RETRIEVER ────────────────────────────

    /** Tokenize text into lowercase words */
    function tokenize(text) {
        return text.toLowerCase()
            .replace(/[^a-z0-9\s]/g, ' ')
            .split(/\s+/)
            .filter(w => w.length > 1);
    }

    /** Compute term frequency */
    function termFrequency(tokens) {
        const tf = {};
        tokens.forEach(t => { tf[t] = (tf[t] || 0) + 1; });
        const len = tokens.length || 1;
        Object.keys(tf).forEach(t => { tf[t] /= len; });
        return tf;
    }

    /** Compute IDF across all documents */
    function computeIDF(docs) {
        const idf = {};
        const N = docs.length;
        docs.forEach(doc => {
            const unique = new Set(tokenize(doc));
            unique.forEach(t => { idf[t] = (idf[t] || 0) + 1; });
        });
        Object.keys(idf).forEach(t => {
            idf[t] = Math.log((N + 1) / (idf[t] + 1)) + 1;
        });
        return idf;
    }

    /** Compute TF-IDF vector */
    function tfidfVector(tokens, idf) {
        const tf = termFrequency(tokens);
        const vec = {};
        Object.keys(tf).forEach(t => {
            vec[t] = tf[t] * (idf[t] || 1);
        });
        return vec;
    }

    /** Cosine similarity between two vectors */
    function cosineSim(a, b) {
        let dot = 0, magA = 0, magB = 0;
        const allKeys = new Set([...Object.keys(a), ...Object.keys(b)]);
        allKeys.forEach(k => {
            const va = a[k] || 0;
            const vb = b[k] || 0;
            dot += va * vb;
            magA += va * va;
            magB += vb * vb;
        });
        if (magA === 0 || magB === 0) return 0;
        return dot / (Math.sqrt(magA) * Math.sqrt(magB));
    }

    /** Retrieve the top-K most relevant knowledge chunks */
    function retrieve(query) {
        if (!knowledgeBase.length) return [];

        const docs = knowledgeBase.map(kb => kb.title + ' ' + kb.content);
        const idf = computeIDF(docs);

        const queryTokens = tokenize(query);
        const queryVec = tfidfVector(queryTokens, idf);

        const scored = knowledgeBase.map((kb, i) => {
            const docTokens = tokenize(docs[i]);
            const docVec = tfidfVector(docTokens, idf);
            return { ...kb, score: cosineSim(queryVec, docVec) };
        });

        scored.sort((a, b) => b.score - a.score);
        return scored.slice(0, CONFIG.topK).filter(s => s.score > 0.05);
    }

    // ──────────────────────────── GEMINI API ────────────────────────────

    /** Build the system prompt with retrieved context */
    function buildPrompt(query, chunks) {
        let context = '';
        if (chunks.length > 0) {
            context = '\n\nRelevant knowledge base information:\n\n';
            chunks.forEach((c, i) => {
                context += `[${i + 1}] ${c.title}\n${c.content}\n\n`;
            });
        }

        const systemPrompt = `You are the Propert-Ease AI Assistant — a friendly, knowledgeable support bot for the Propert-Ease society governance platform.

RULES:
1. For questions about Propert-Ease, housing societies, governance, compliance, billing, maintenance, or related topics — answer helpfully using the provided knowledge base context below. You may elaborate naturally.
2. If the user's question is about Propert-Ease but the exact answer isn't in the context, give a helpful general answer and suggest they book a free demo or contact support@propertease.in for specifics.
3. ONLY if the question is COMPLETELY IRRELEVANT to Propert-Ease or housing/society management (e.g. weather, sports, cooking, movies, coding, math) — politely say: "I'm specialized in Propert-Ease and society governance. For this question, I'd recommend checking other resources. Is there anything about Propert-Ease I can help with?"
4. Be concise, helpful, and professional. Use bullet points for lists.
5. Never fabricate specific pricing numbers — say pricing is customized and suggest contacting sales.
6. Keep responses under 150 words unless more detail is needed.
7. Use a warm, professional tone suitable for Indian housing society committees.
${context}`;

        return systemPrompt;
    }

    /** Try a single API call with a specific model */
    async function tryGeminiCall(modelName, systemPrompt, contents) {
        const url = `https://generativelanguage.googleapis.com/v1beta/models/${modelName}:generateContent?key=${CONFIG.apiKey}`;

        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                system_instruction: {
                    parts: [{ text: systemPrompt }]
                },
                contents: contents,
                generationConfig: {
                    temperature: 0.7,
                    maxOutputTokens: 500,
                }
            })
        });

        if (!response.ok) {
            const err = await response.json().catch(() => ({}));
            throw { status: response.status, body: err };
        }

        const data = await response.json();
        const text = data?.candidates?.[0]?.content?.parts?.[0]?.text;
        if (!text) throw { status: 0, body: 'Empty response' };
        return text;
    }

    /** Send message to Gemini API — tries multiple models with retry */
    async function callGemini(query, chunks) {
        if (!CONFIG.apiKey || CONFIG.apiKey === 'YOUR_GEMINI_API_KEY_HERE') {
            return "⚠️ API key not configured. Please set your Gemini API key to enable the chatbot.";
        }

        const systemPrompt = buildPrompt(query, chunks);

        // Build contents array with history
        const contents = [];
        chatHistory.forEach(msg => {
            contents.push({
                role: msg.role === 'user' ? 'user' : 'model',
                parts: [{ text: msg.text }]
            });
        });
        contents.push({ role: 'user', parts: [{ text: query }] });

        // Try the working model first, then fallbacks
        const modelsToTry = [workingModel, ...CONFIG.models.filter(m => m !== workingModel)];
        let lastError = null;

        for (const model of modelsToTry) {
            // Try up to 2 times per model (with delay on 429)
            for (let attempt = 0; attempt < 2; attempt++) {
                try {
                    console.log(`[Chatbot] Trying model: ${model} (attempt ${attempt + 1})`);
                    const text = await tryGeminiCall(model, systemPrompt, contents);
                    workingModel = model; // remember which model worked
                    console.log(`[Chatbot] Success with model: ${model}`);
                    return text;
                } catch (err) {
                    lastError = err;
                    console.warn(`[Chatbot] ${model} failed (${err.status}):`, err.body);

                    if (err.status === 429 && attempt === 0) {
                        // Rate limited — wait and retry same model
                        console.log(`[Chatbot] Rate limited, waiting 3s...`);
                        await new Promise(r => setTimeout(r, 3000));
                        continue;
                    }
                    break; // try next model
                }
            }
        }

        // All models failed
        console.error('[Chatbot] All models failed. Last error:', lastError);
        if (lastError?.status === 429) {
            return "I'm experiencing high traffic right now. Please wait a few seconds and try again! 😊";
        }
        if (lastError?.status === 403) {
            return "⚠️ API key issue. Please verify your Gemini API key at https://aistudio.google.com/apikey";
        }
        return "Sorry, I'm having trouble connecting. Please try again or contact us at support@propertease.in.";
    }

    // ──────────────────────────── CHAT UI ────────────────────────────

    /** Inject the chat widget HTML into the page */
    function createChatWidget() {
        const widget = document.createElement('div');
        widget.id = 'pe-chatbot';
        widget.innerHTML = `
      <!-- Floating Action Button -->
      <button id="pe-chat-fab" aria-label="Open chat">
        <svg id="pe-fab-icon-chat" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        <svg id="pe-fab-icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
        <span id="pe-fab-pulse"></span>
      </button>

      <!-- Chat Window -->
      <div id="pe-chat-window">
        <!-- Header -->
        <div id="pe-chat-header">
          <div id="pe-chat-header-info">
            <div id="pe-chat-avatar">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                <path d="M2 17l10 5 10-5"></path>
                <path d="M2 12l10 5 10-5"></path>
              </svg>
            </div>
            <div>
              <h4 id="pe-chat-title">${CONFIG.botName}</h4>
              <span id="pe-chat-status">
                <span id="pe-status-dot"></span>
                Online
              </span>
            </div>
          </div>
          <button id="pe-chat-minimize" aria-label="Minimize chat">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
          </button>
        </div>

        <!-- Messages Area -->
        <div id="pe-chat-messages"></div>

        <!-- Quick Actions -->
        <div id="pe-quick-actions">
          <button class="pe-quick-btn" data-query="What is Propert-Ease?">What is Propert-Ease?</button>
          <button class="pe-quick-btn" data-query="What are the pricing plans?">Pricing Plans</button>
          <button class="pe-quick-btn" data-query="How do I get started?">Get Started</button>
          <button class="pe-quick-btn" data-query="What features do you offer?">Features</button>
        </div>

        <!-- Input Area -->
        <div id="pe-chat-input-area">
          <input type="text" id="pe-chat-input" placeholder="Ask about Propert-Ease..." autocomplete="off">
          <button id="pe-chat-send" aria-label="Send message">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="22" y1="2" x2="11" y2="13"></line>
              <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
          </button>
        </div>

        <!-- Footer -->
        <div id="pe-chat-footer">
          Powered by <strong>Propert-Ease AI</strong>
        </div>
      </div>
    `;

        document.body.appendChild(widget);
    }

    /** Add a message to the chat window */
    function addMessage(text, sender) {
        const container = document.getElementById('pe-chat-messages');
        if (!container) return;

        const msgDiv = document.createElement('div');
        msgDiv.className = `pe-message pe-message-${sender}`;

        const bubble = document.createElement('div');
        bubble.className = 'pe-bubble';

        if (sender === 'bot') {
            bubble.innerHTML = simpleMarkdown(text);
        } else {
            bubble.textContent = text;
        }

        const time = document.createElement('span');
        time.className = 'pe-msg-time';
        const now = new Date();
        time.textContent = now.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });

        msgDiv.appendChild(bubble);
        msgDiv.appendChild(time);
        container.appendChild(msgDiv);

        // Animate in
        requestAnimationFrame(() => msgDiv.classList.add('pe-msg-visible'));

        // Scroll to bottom
        container.scrollTop = container.scrollHeight;
    }

    /** Show/hide typing indicator */
    function showTyping(show) {
        isTyping = show;
        const container = document.getElementById('pe-chat-messages');
        let typing = document.getElementById('pe-typing-indicator');

        if (show && !typing) {
            typing = document.createElement('div');
            typing.id = 'pe-typing-indicator';
            typing.className = 'pe-message pe-message-bot';
            typing.innerHTML = `
        <div class="pe-bubble pe-typing-bubble">
          <span class="pe-dot"></span>
          <span class="pe-dot"></span>
          <span class="pe-dot"></span>
        </div>
      `;
            container.appendChild(typing);
            requestAnimationFrame(() => typing.classList.add('pe-msg-visible'));
            container.scrollTop = container.scrollHeight;
        } else if (!show && typing) {
            typing.remove();
        }
    }

    /** Handle sending a message */
    async function handleSend(queryText) {
        const input = document.getElementById('pe-chat-input');
        const query = queryText || (input ? input.value.trim() : '');

        if (!query || isTyping) return;
        if (input) input.value = '';

        // Hide quick actions after first message
        const quickActions = document.getElementById('pe-quick-actions');
        if (quickActions) quickActions.style.display = 'none';

        // Show user message
        addMessage(query, 'user');

        // Show typing
        showTyping(true);

        // Retrieve relevant chunks
        const chunks = retrieve(query);

        // Call Gemini
        const response = await callGemini(query, chunks);

        // Hide typing, show response
        showTyping(false);
        addMessage(response, 'bot');

        // Update history (keep last N exchanges)
        chatHistory.push({ role: 'user', text: query });
        chatHistory.push({ role: 'assistant', text: response });
        if (chatHistory.length > CONFIG.maxHistory * 2) {
            chatHistory = chatHistory.slice(-CONFIG.maxHistory * 2);
        }
    }

    /** Toggle chat window open/closed */
    function toggleChat() {
        isOpen = !isOpen;
        const window = document.getElementById('pe-chat-window');
        const chatIcon = document.getElementById('pe-fab-icon-chat');
        const closeIcon = document.getElementById('pe-fab-icon-close');
        const pulse = document.getElementById('pe-fab-pulse');

        if (isOpen) {
            window.classList.add('pe-chat-open');
            chatIcon.style.display = 'none';
            closeIcon.style.display = 'block';
            if (pulse) pulse.style.display = 'none';
            document.getElementById('pe-chat-input')?.focus();
        } else {
            window.classList.remove('pe-chat-open');
            chatIcon.style.display = 'block';
            closeIcon.style.display = 'none';
        }
    }

    /** Bind event listeners */
    function bindEvents() {
        // FAB click
        document.getElementById('pe-chat-fab')?.addEventListener('click', toggleChat);

        // Minimize button
        document.getElementById('pe-chat-minimize')?.addEventListener('click', toggleChat);

        // Send button
        document.getElementById('pe-chat-send')?.addEventListener('click', () => handleSend());

        // Enter key
        document.getElementById('pe-chat-input')?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleSend();
            }
        });

        // Quick action buttons
        document.querySelectorAll('.pe-quick-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                handleSend(btn.getAttribute('data-query'));
            });
        });
    }

    // ──────────────────────────── INITIALIZATION ────────────────────────────

    async function loadKnowledgeBase() {
        const basePath = getBasePath();
        const url = basePath + 'knowledge-base.json';

        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            knowledgeBase = await response.json();
            console.log(`[Propert-Ease Chatbot] Loaded ${knowledgeBase.length} knowledge chunks.`);
        } catch (error) {
            console.error('[Propert-Ease Chatbot] Failed to load knowledge base:', error);
            // Fallback: minimal knowledge
            knowledgeBase = [{
                id: 0,
                title: 'About Propert-Ease',
                content: 'Propert-Ease is a digital governance platform for Indian housing societies. For more info, visit our website or book a demo.'
            }];
        }
    }

    async function init() {
        // Wait for DOM
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
            return;
        }

        // Load knowledge base
        await loadKnowledgeBase();

        // Create UI
        createChatWidget();

        // Bind events
        bindEvents();

        // Show welcome message
        setTimeout(() => {
            addMessage(CONFIG.welcomeMessage, 'bot');
        }, 500);

        console.log('[Propert-Ease Chatbot] Initialized successfully.');
    }

    // Start!
    init();

})();
