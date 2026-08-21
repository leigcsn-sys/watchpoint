<nav class="sticky top-0 z-20 border-b border-[#e5e7eb] bg-white/80 backdrop-blur-md">
    <div class="app-shell">
        <div class="flex h-16 items-center justify-between gap-4">
            <a href="{{ route('watches.index') }}" class="inline-flex items-center gap-2 rounded-full border border-[#111827]/10 bg-[#111827] px-3 py-1.5 font-['JetBrains_Mono'] text-xs font-semibold uppercase tracking-[0.2em] text-white shadow-sm">
                watchpoint
            </a>

            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('watches.index') }}"
                   class="rounded-full px-3 py-2 text-[11px] font-medium uppercase tracking-[0.18em] {{ request()->routeIs('watches.*') ? 'bg-[#111827] text-white' : 'text-[#6B7280] hover:bg-[#111827]/5 hover:text-[#111827]' }} transition-colors">
                    watches
                </a>
                <a href="{{ route('profile.edit') }}" class="rounded-full px-3 py-2 text-[11px] font-medium uppercase tracking-[0.18em] text-[#6B7280] hover:bg-[#111827]/5 hover:text-[#111827] transition-colors">profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full px-3 py-2 text-[11px] font-medium uppercase tracking-[0.18em] text-[#6B7280] hover:bg-[#111827]/5 hover:text-[#111827] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#111827] focus-visible:ring-offset-2 transition-colors">logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>