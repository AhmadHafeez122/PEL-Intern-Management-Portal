@once
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endonce

<div id="pel-chatbot" x-data="pelChatbot()" x-cloak>

    {{-- ─── Floating Toggle Button ────────────────────────────────────────── --}}
    <button
        @click="toggle()"
        class="fixed bottom-6 right-6 z-[9999] group"
        :class="isOpen ? 'scale-0 opacity-0 pointer-events-none' : 'scale-100 opacity-100'"
        style="transition: all 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);"
    >
        {{-- Pulse ring --}}
        <span class="absolute inset-0 rounded-full bg-pel-blue animate-ping opacity-25"></span>
        {{-- Button body --}}
        <span class="relative flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-pel-blue to-blue-700 text-white shadow-[0_8px_32px_rgba(0,91,170,0.45)] hover:shadow-[0_12px_40px_rgba(0,91,170,0.6)] hover:scale-110 transition-all duration-300">
            {{-- AI Bot Icon --}}
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
            </svg>
        </span>
    </button>

    {{-- ─── Chat Window ───────────────────────────────────────────────────── --}}
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-400"
        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 scale-95"
        class="fixed bottom-6 right-6 z-[9999] w-[400px] max-w-[calc(100vw-2rem)] flex flex-col rounded-3xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.3)]"
        style="height: 600px; max-height: calc(100vh - 3rem);"
    >

        {{-- ── Header ─────────────────────────────────────────────────────── --}}
        <div class="relative bg-gradient-to-r from-pel-dark via-[#0d3868] to-pel-blue px-5 py-4 flex-shrink-0">
            {{-- Decorative circles --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-8 w-20 h-20 bg-white/5 rounded-full translate-y-1/2"></div>

            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-3">
                    {{-- Avatar --}}
                    <div class="relative">
                        <div class="w-11 h-11 rounded-xl bg-white/15 backdrop-blur-sm flex items-center justify-center border border-white/20">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
                            </svg>
                        </div>
                        {{-- Online dot --}}
                        <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-400 rounded-full border-2 border-pel-dark"></span>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold text-sm leading-tight">PEL Assistant</h4>
                        <p class="text-blue-200/80 text-xs flex items-center gap-1.5 mt-0.5">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                            Online • AI Powered
                        </p>
                    </div>
                </div>

                {{-- Close button --}}
                <button @click="toggle()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white/80 hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── Messages Area ──────────────────────────────────────────────── --}}
        <div
            x-ref="messagesContainer"
            class="flex-1 overflow-y-auto px-4 py-5 space-y-4 bg-gradient-to-b from-gray-50 to-white"
            style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;"
        >
            <template x-for="(msg, index) in messages" :key="index">
                <div>
                    {{-- Bot message --}}
                    <template x-if="msg.type === 'bot'">
                        <div class="flex items-start gap-2.5 animate-fade-in-up" style="animation-duration: 0.4s;">
                            {{-- Bot avatar --}}
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-pel-blue to-blue-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                                </svg>
                            </div>
                            <div class="max-w-[80%]">
                                <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-md px-4 py-3 shadow-sm">
                                    <div x-html="formatMessage(msg.text)" class="text-sm text-gray-700 leading-relaxed chatbot-content"></div>
                                </div>
                                <span class="text-[10px] text-gray-400 ml-2 mt-1 block" x-text="msg.time"></span>
                            </div>
                        </div>
                    </template>

                    {{-- User message --}}
                    <template x-if="msg.type === 'user'">
                        <div class="flex justify-end animate-fade-in-up" style="animation-duration: 0.3s;">
                            <div class="max-w-[80%]">
                                <div class="bg-gradient-to-br from-pel-blue to-blue-600 text-white rounded-2xl rounded-tr-md px-4 py-3 shadow-md">
                                    <p class="text-sm leading-relaxed" x-text="msg.text"></p>
                                </div>
                                <span class="text-[10px] text-gray-400 mr-2 mt-1 block text-right" x-text="msg.time"></span>
                            </div>
                        </div>
                    </template>

                    {{-- Suggestions --}}
                    <template x-if="msg.type === 'suggestions' && msg.items.length > 0">
                        <div class="flex flex-wrap gap-2 ml-10 animate-fade-in-up" style="animation-duration: 0.5s;">
                            <template x-for="(sug, sIndex) in msg.items" :key="sIndex">
                                <button
                                    @click="sendMessage(sug)"
                                    class="px-3.5 py-2 text-xs font-medium bg-white border border-pel-blue/20 text-pel-blue rounded-full hover:bg-pel-blue hover:text-white hover:border-pel-blue shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5"
                                    x-text="sug"
                                ></button>
                            </template>
                        </div>
                    </template>
                </div>
            </template>

            {{-- Typing indicator --}}
            <div x-show="isTyping" class="flex items-start gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-pel-blue to-blue-600 flex items-center justify-center flex-shrink-0 shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-md px-5 py-3.5 shadow-sm">
                    <div class="flex gap-1.5 items-center">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Input Area ─────────────────────────────────────────────────── --}}
        <div class="flex-shrink-0 bg-white border-t border-gray-100 px-4 py-3">
            <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                <div class="flex-1 relative">
                    <input
                        x-ref="chatInput"
                        x-model="inputText"
                        type="text"
                        placeholder="Ask about PEL internships..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pel-blue/30 focus:border-pel-blue/50 transition-all"
                        :disabled="isTyping"
                        maxlength="500"
                    />
                </div>
                <button
                    type="submit"
                    :disabled="!inputText.trim() || isTyping"
                    class="w-11 h-11 rounded-xl flex items-center justify-center transition-all duration-200 flex-shrink-0"
                    :class="inputText.trim() && !isTyping
                        ? 'bg-gradient-to-br from-pel-blue to-blue-600 text-white shadow-lg shadow-pel-blue/30 hover:shadow-xl hover:scale-105 cursor-pointer'
                        : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                    </svg>
                </button>
            </form>
            <p class="text-[10px] text-gray-400 text-center mt-2">Powered by PEL AI • Internship Portal Assistant</p>
        </div>

    </div>
</div>

{{-- ─── Chatbot Styles ────────────────────────────────────────────────────── --}}
<style>
    [x-cloak] { display: none !important; }

    /* Chatbot content markdown styling */
    .chatbot-content strong { font-weight: 600; color: #1a202c; }
    .chatbot-content a { color: #005baa; text-decoration: underline; font-weight: 500; }
    .chatbot-content a:hover { color: #003d73; }
    .chatbot-content p { margin-bottom: 0.5rem; }
    .chatbot-content p:last-child { margin-bottom: 0; }

    /* Custom scrollbar for the chat area */
    #pel-chatbot ::-webkit-scrollbar { width: 5px; }
    #pel-chatbot ::-webkit-scrollbar-track { background: transparent; }
    #pel-chatbot ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    #pel-chatbot ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Smooth animation for messages */
    @keyframes chatFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

{{-- ─── Chatbot Script ────────────────────────────────────────────────────── --}}
<script>
    function pelChatbot() {
        return {
            isOpen: false,
            isTyping: false,
            inputText: '',
            messages: [],

            init() {
                // Welcome message shown when chat first opens
                this.$watch('isOpen', (val) => {
                    if (val && this.messages.length === 0) {
                        this.addBotMessage(
                            "Hello! 👋 I'm the **PEL Portal Assistant** — powered by real-time portal data. I can show you live stats about interns, supervisors, departments, applications, and more.\n\nWhat would you like to know?",
                            ['Portal statistics', 'Show departments', 'Show supervisors', 'How to apply?']
                        );
                    }
                    if (val) {
                        this.$nextTick(() => this.$refs.chatInput?.focus());
                    }
                });
            },

            toggle() {
                this.isOpen = !this.isOpen;
            },

            getTime() {
                return new Date().toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
            },

            formatMessage(text) {
                if (!text) return '';
                // Convert markdown-style bold **text** to <strong>
                let html = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                // Convert markdown links [text](url)
                html = html.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" target="_blank">$1</a>');
                // Convert newlines to <br> then handle paragraphs
                html = html.replace(/\n\n/g, '</p><p>');
                html = html.replace(/\n/g, '<br>');
                // Convert list items (• or →)
                html = html.replace(/^[•→]\s*/gm, '&bull; ');
                return '<p>' + html + '</p>';
            },

            addBotMessage(text, suggestions = []) {
                this.messages.push({ type: 'bot', text: text, time: this.getTime() });
                if (suggestions.length > 0) {
                    this.messages.push({ type: 'suggestions', items: suggestions });
                }
                this.scrollToBottom();
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const container = this.$refs.messagesContainer;
                    if (container) {
                        container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
                    }
                });
            },

            async sendMessage(text = null) {
                const message = text || this.inputText.trim();
                if (!message) return;

                // Remove previous suggestion buttons
                this.messages = this.messages.filter(m => m.type !== 'suggestions');

                // Add user message
                this.messages.push({ type: 'user', text: message, time: this.getTime() });
                this.inputText = '';
                this.scrollToBottom();

                // Show typing indicator
                this.isTyping = true;
                this.scrollToBottom();

                try {
                    const response = await fetch('{{ route("chatbot.chat") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ message: message }),
                    });

                    if (!response.ok) throw new Error('Network response was not ok');

                    const data = await response.json();

                    // Simulate typing delay for realism
                    await new Promise(resolve => setTimeout(resolve, 600 + Math.random() * 800));

                    this.isTyping = false;
                    this.addBotMessage(data.reply, data.suggestions || []);

                } catch (error) {
                    console.error('Chatbot error:', error);
                    await new Promise(resolve => setTimeout(resolve, 500));
                    this.isTyping = false;
                    this.addBotMessage(
                        "I'm sorry, I encountered a connection issue. Please try again in a moment. If the problem persists, contact us at **internships@pel.com.pk**.",
                        ['Try again', 'Contact support']
                    );
                }

                this.$nextTick(() => this.$refs.chatInput?.focus());
            }
        };
    }
</script>
