require('dotenv').config();
const http = require('http');
const fs = require('fs');
const path = require('path');

const PORT = 3000;

const MIME_TYPES = {
    '.html': 'text/html',
    '.css': 'text/css',
    '.js': 'application/javascript',
    '.json': 'application/json',
    '.png': 'image/png',
    '.jpg': 'image/jpeg',
    '.jpeg': 'image/jpeg',
    '.gif': 'image/gif',
    '.svg': 'image/svg+xml',
    '.ico': 'image/x-icon',
    '.woff': 'font/woff',
    '.woff2': 'font/woff2',
    '.ttf': 'font/ttf',
    '.eot': 'application/vnd.ms-fontobject',
    '.mp4': 'video/mp4',
    '.webp': 'image/webp',
    '.pdf': 'application/pdf',
};

const server = http.createServer(async (req, res) => {
    // Handle the /api/chat endpoint
    if (req.url === '/api/chat' && req.method === 'POST') {
        let body = '';
        req.on('data', chunk => { body += chunk; });
        req.on('end', async () => {
            try {
                const { systemPrompt, messages } = JSON.parse(body);
                const apiKey = process.env.OPENROUTER_API_KEY;

                if (!apiKey) {
                    res.writeHead(500, { 'Content-Type': 'application/json' });
                    res.end(JSON.stringify({ error: 'OpenRouter API key not configured. Add OPENROUTER_API_KEY to your .env file.' }));
                    return;
                }

                // Build OpenRouter messages
                const openRouterMessages = [];
                if (systemPrompt) {
                    openRouterMessages.push({ role: 'system', content: systemPrompt });
                }
                if (messages && Array.isArray(messages)) {
                    messages.forEach(msg => {
                        openRouterMessages.push({
                            role: msg.role === 'model' ? 'assistant' : msg.role,
                            content: msg.content
                        });
                    });
                }

                const response = await fetch('https://openrouter.ai/api/v1/chat/completions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${apiKey}`,
                        'HTTP-Referer': 'http://localhost:3000',
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
                    res.writeHead(response.status, { 'Content-Type': 'application/json' });
                    res.end(JSON.stringify({ error: data?.error?.message || 'OpenRouter API error' }));
                    return;
                }

                const reply = data?.choices?.[0]?.message?.content || '';
                res.writeHead(200, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ reply }));
            } catch (error) {
                console.error('Server error:', error);
                res.writeHead(500, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ error: 'Internal server error' }));
            }
        });
        return;
    }

    // Serve static files
    let filePath = req.url === '/' ? '/index.html' : req.url;
    filePath = path.join(__dirname, decodeURIComponent(filePath.split('?')[0]));

    const ext = path.extname(filePath).toLowerCase();
    const contentType = MIME_TYPES[ext] || 'application/octet-stream';

    fs.readFile(filePath, (err, data) => {
        if (err) {
            if (err.code === 'ENOENT') {
                res.writeHead(404, { 'Content-Type': 'text/html' });
                res.end('<h1>404 Not Found</h1>');
            } else {
                res.writeHead(500);
                res.end('Server Error');
            }
            return;
        }
        res.writeHead(200, { 'Content-Type': contentType });
        res.end(data);
    });
});

server.listen(PORT, () => {
    console.log(`\n  🏠 Propert-Ease Local Server`);
    console.log(`  ➜ http://localhost:${PORT}`);
    console.log(`  ➜ API Key: ${process.env.OPENROUTER_API_KEY ? '✅ Loaded from .env' : '❌ Missing! Add OPENROUTER_API_KEY to .env'}\n`);
});
