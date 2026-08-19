<nav class="bg-white border-b border-[#E5E5E5]">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('watches.index') }}" class="font-['JetBrains_Mono'] font-semibold text-sm text-[#111111] tracking-tight">
                watchpoint
            </a>
            <div class="flex items-center gap-4 sm:gap-6">
                <a href="{{ route('watches.index') }}"
                   class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest {{ request()->routeIs('watches.*') ? 'text-[#111111]' : 'text-[#9CA3AF] hover:text-[#111111]' }} transition-colors">
                    watches
                </a>
                <a href="{{ route('profile.edit') }}" class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-[#111111] transition-colors">profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-[#111111] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#111111] focus-visible:ring-offset-4 transition-colors">logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>