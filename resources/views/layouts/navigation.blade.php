<nav class="bg-white border-b border-[#E5E5E5]">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('watches.index') }}" class="font-['JetBrains_Mono'] font-semibold text-sm text-[#111111] tracking-tight">
                watchpoint
            </a>
            <a href="{{ route('watches.index') }}"
               class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest {{ request()->routeIs('watches.*') ? 'text-[#111111]' : 'text-[#9CA3AF] hover:text-[#111111]' }} transition-colors">
                watches
            </a>
        </div>
    </div>
</nav>