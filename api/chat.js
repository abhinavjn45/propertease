export default async function handler(req, res) {
    if (req.method !== 'POST') {
        return res.status(405).json({ error: 'Method not allowed' });
    }

    const { systemPrompt, messages } = req.body;
    const apiKey = process.env.OPENROUTER_API_KEY;

    if (!apiKey) {
        return res.status(500).json({ error: 'OpenRouter API key not configured on server' });
    }

    // Build the messages array for OpenRouter (OpenAI-compatible format)
    const openRouterMessages = [];

    // Add system prompt
    if (systemPrompt) {
        openRouterMessages.push({ role: 'system', content: systemPrompt });
    }

    // Add conversation messages
    if (messages && Array.isArray(messages)) {
        messages.forEach(msg => {
            openRouterMessages.push({
                role: msg.role === 'model' ? 'assistant' : msg.role,
                content: msg.content
            });
        });
    }

    try {
        const response = await fetch('https://openrouter.ai/api/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${apiKey}`,
                'HTTP-Referer': req.headers.referer || 'https://propertease.in',
                'X-Title': 'Propert-Ease Chatbot'
            },
            body: JSON.stringify({
                model: 'google/gemini-2.5-flash',
                messages: openRouterMessages,
                temperature: 0.7,
                max_tokens: 500,
            })
        });

        const data = await response.json();

        if (!response.ok) {
            console.error('OpenRouter error:', data);
            return res.status(response.status).json({
                error: data?.error?.message || 'OpenRouter API error'
            });
        }

        // Return in a simplified format the client can parse
        const reply = data?.choices?.[0]?.message?.content || '';
        return res.status(200).json({ reply });
    } catch (error) {
        console.error('Proxy error:', error);
        return res.status(500).json({ error: 'Internal server error' });
    }
}
