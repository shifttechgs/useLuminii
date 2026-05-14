<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — Luminii CRM</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/crm.css', 'resources/js/crm.js'])
    <link rel="stylesheet" href="{{ asset('css/crm-design-system.css') }}">
    <!-- Alpine.js (used for nav-group collapsibles and user dropdown) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    {{--
        Sidebar state: runs synchronously before CSS renders.
        On desktop, restore the last state (default: open).
        On mobile, always start closed regardless of stored state.
        This prevents any visible flash on page load.
    --}}
    <script>
    (function(){
        var stored = localStorage.getItem('crm_sidebar');
        var isDesktop = window.innerWidth >= 1024;
        var open = isDesktop ? (stored !== null ? stored === '1' : true) : false;
        if (open) document.documentElement.classList.add('crm-sb-open');
    })();
    </script>
    {{ $head ?? '' }}
    @stack('head')
</head>
<body>

<div class="crm-shell">

    {{-- Backdrop overlay — visible on mobile only when sidebar is open (CSS-controlled) --}}
    <div class="crm-sidebar-overlay" onclick="crmSidebar.toggle()"></div>

    {{-- ── Sidebar ── --}}
    <aside class="crm-sidebar">

        {{-- Logo --}}
        <div class="crm-sidebar-header">
            <a href="{{ route('crm.dashboard') }}" class="crm-brand-logo" style="text-decoration:none;user-select:none;">
                <img
                    src="{{ asset('assets/images/logo/useluminii_logos/useluminii_dark.png') }}"
                    alt="useLuminii"
                    class="crm-brand-logo__img crm-brand-logo__img--dark"
                >
                <img
                    src="{{ asset('assets/images/logo/useluminii_logos/useluminii_light.png') }}"
                    alt="useLuminii"
                    class="crm-brand-logo__img crm-brand-logo__img--light"
                >
            </a>
        </div>

        {{-- Navigation --}}
        @php
            $reportsOpen = request()->routeIs('crm.reports');
        @endphp
        <nav class="crm-sidebar-nav">

            {{-- Dashboard (standalone) --}}
            <a href="{{ route('crm.dashboard') }}"
               class="crm-nav-item {{ request()->routeIs('crm.dashboard') ? 'active' : '' }}"
               style="margin-bottom:0.5rem;">
                <svg class="crm-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            {{-- CRM Group --}}
            <div class="crm-nav-group" data-open="true">
                <button type="button" class="crm-nav-group-hdr" onclick="crmNavGroup.toggle(this)">
                    <svg class="crm-nav-group-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                    </svg>
                    <span class="crm-nav-group-lbl">CRM</span>
                    <svg class="crm-nav-group-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                    </svg>
                </button>
                <div class="crm-nav-tree">
                    <a href="{{ route('crm.clients.index') }}" class="crm-nav-leaf {{ request()->routeIs('crm.clients.*') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Clients
                        @if($leadsCount > 0) <span class="crm-nav-badge">{{ $leadsCount }}</span> @endif
                    </a>
                    <a href="{{ route('crm.requests.index') }}" class="crm-nav-leaf {{ request()->routeIs('crm.requests.*') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Client Requests
                        @if($newRequestsCount > 0) <span class="crm-nav-badge">{{ $newRequestsCount }}</span> @endif
                    </a>
                    <a href="{{ route('crm.leads.index') }}" class="crm-nav-leaf {{ request()->routeIs('crm.leads.*') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Leads
                        @if($newLeadsCount > 0) <span class="crm-nav-badge">{{ $newLeadsCount }}</span> @endif
                    </a>
                    <a href="{{ route('crm.pipeline') }}" class="crm-nav-leaf {{ request()->routeIs('crm.pipeline') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Pipeline
                    </a>
                </div>
            </div>

            {{-- Operations Group --}}
            <div class="crm-nav-group" data-open="true">
                <button type="button" class="crm-nav-group-hdr" onclick="crmNavGroup.toggle(this)">
                    <svg class="crm-nav-group-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/>
                    </svg>
                    <span class="crm-nav-group-lbl">Operations</span>
                    <svg class="crm-nav-group-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                    </svg>
                </button>
                <div class="crm-nav-tree">
                    <a href="{{ route('crm.quotes.index') }}" class="crm-nav-leaf {{ request()->routeIs('crm.quotes.*') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Quotes
                        @if($draftQuotesCount > 0) <span class="crm-nav-badge">{{ $draftQuotesCount }}</span> @endif
                    </a>
                    <a href="{{ route('crm.calendar') }}" class="crm-nav-leaf {{ request()->routeIs('crm.calendar') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Job Calendar
                    </a>
                    <a href="{{ route('crm.jobs.index') }}" class="crm-nav-leaf {{ request()->routeIs('crm.jobs.*') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Jobs
                        @if($activeJobsCount > 0) <span class="crm-nav-badge">{{ $activeJobsCount }}</span> @endif
                    </a>
                </div>
            </div>

            {{-- Finance Group --}}
            <div class="crm-nav-group" data-open="true">
                <button type="button" class="crm-nav-group-hdr" onclick="crmNavGroup.toggle(this)">
                    <svg class="crm-nav-group-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                    </svg>
                    <span class="crm-nav-group-lbl">Finance</span>
                    <svg class="crm-nav-group-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                    </svg>
                </button>
                <div class="crm-nav-tree">
                    <a href="{{ route('crm.invoices.index') }}" class="crm-nav-leaf {{ request()->routeIs('crm.invoices.*') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Invoices
                        @if($overdueInvoicesCount > 0) <span class="crm-nav-badge">{{ $overdueInvoicesCount }}</span> @endif
                    </a>
                    <a href="{{ route('crm.recurring.index') }}" class="crm-nav-leaf {{ request()->routeIs('crm.recurring.*') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Recurring Invoices
                    </a>
                    <a href="{{ route('crm.expenses.index') }}" class="crm-nav-leaf {{ request()->routeIs('crm.expenses.*') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Expenses
                    </a>
                </div>
            </div>

            {{-- Reports Group --}}
            <div class="crm-nav-group" data-open="{{ $reportsOpen ? 'true' : 'false' }}">
                <button type="button" class="crm-nav-group-hdr" onclick="crmNavGroup.toggle(this)">
                    <svg class="crm-nav-group-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                    <span class="crm-nav-group-lbl">Reports</span>
                    <svg class="crm-nav-group-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                    </svg>
                </button>
                <div class="crm-nav-tree">
                    <a href="{{ route('crm.reports') }}" class="crm-nav-leaf {{ request()->routeIs('crm.reports') ? 'active' : '' }}">
                        <span class="crm-leaf-dot"></span>
                        Reports
                    </a>
                </div>
            </div>

        </nav>

        {{-- User footer --}}
        <div class="crm-sidebar-footer">
            @auth
            <div class="crm-sidebar-account">
                <button type="button" class="crm-user-card" aria-haspopup="true">
                    <div class="crm-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:0.8125rem;font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</p>
                        <p style="font-size:0.6875rem;color:rgba(255,255,255,0.4);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->email }}</p>
                    </div>
                    <svg style="width:1rem;height:1rem;color:rgba(255,255,255,0.3);flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/></svg>
                </button>

                <div class="crm-sidebar-account-menu" role="menu">
                    <a href="{{ route('crm.services.index') }}" class="crm-dropdown-item {{ request()->routeIs('crm.services.*') ? 'active' : '' }}" role="menuitem">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.93 23.93 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4.5A2.5 2.5 0 0013.5 2h-3A2.5 2.5 0 008 4.5V6m11 0H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2z"/></svg>
                        Business Services
                    </a>
                    <a href="{{ route('crm.team.index') }}" class="crm-dropdown-item {{ request()->routeIs('crm.team.*') ? 'active' : '' }}" role="menuitem">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m8-3.13a4 4 0 10-6 0m6 0a4 4 0 016 3.46M9 11a4 4 0 00-6 3.46"/></svg>
                        Team
                    </a>
                    <a href="{{ route('crm.notifications.index') }}" class="crm-dropdown-item {{ request()->routeIs('crm.notifications.*') ? 'active' : '' }}" role="menuitem">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0"/></svg>
                        Notifications
                        @if($unreadNotifications > 0) <span class="crm-nav-badge">{{ $unreadNotifications }}</span> @endif
                    </a>
                    <a href="{{ route('crm.settings') }}" class="crm-dropdown-item {{ request()->routeIs('crm.settings') ? 'active' : '' }}" role="menuitem">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Settings
                    </a>
                    <div class="crm-dropdown-sep"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="crm-dropdown-item crm-dropdown-item-danger" style="width:100%;" role="menuitem">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </aside>

    {{-- ── Main content ── --}}
    <div class="crm-main">

        {{-- Topbar --}}
        <header class="crm-topbar">

            {{-- Hamburger — always visible, drives sidebar via crmSidebar.toggle() --}}
            <button onclick="crmSidebar.toggle()"
                    class="crm-icon-btn crm-menu-btn"
                    aria-label="Toggle navigation">
                <svg class="crm-icon-menu" style="width:1.25rem;height:1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg class="crm-icon-close" style="width:1.25rem;height:1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <span class="crm-topbar-title">{{ $title }}</span>

            <div class="crm-topbar-actions">
                {{-- Notifications bell --}}
                <a href="{{ route('crm.notifications.index') }}" class="crm-icon-btn" style="position:relative;">
                    <svg style="width:1.125rem;height:1.125rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @if($unreadNotifications > 0)
                        <span style="position:absolute;top:4px;right:4px;width:8px;height:8px;background:#f04438;border-radius:50%;border:1.5px solid #fff;"></span>
                    @endif
                </a>

                {{-- User avatar + hover dropdown --}}
                @auth
                <div class="crm-topbar-user">
                    <button class="crm-topbar-avatar" type="button" aria-label="Account menu">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </button>
                    <div class="crm-topbar-dropdown" role="menu">
                        <div class="crm-topbar-dd-inner">
                            <div class="crm-topbar-dd-header">
                                <span class="crm-topbar-dd-name">{{ auth()->user()->name }}</span>
                                <span class="crm-topbar-dd-email">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="crm-topbar-dd-body">
                                <a href="{{ route('crm.services.index') }}" class="crm-topbar-dd-item {{ request()->routeIs('crm.services.*') ? 'active' : '' }}" role="menuitem">
                                    <svg style="width:0.875rem;height:0.875rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.93 23.93 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4.5A2.5 2.5 0 0013.5 2h-3A2.5 2.5 0 008 4.5V6m11 0H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2z"/>
                                    </svg>
                                    Business Services
                                </a>
                                <a href="{{ route('crm.team.index') }}" class="crm-topbar-dd-item {{ request()->routeIs('crm.team.*') ? 'active' : '' }}" role="menuitem">
                                    <svg style="width:0.875rem;height:0.875rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m8-3.13a4 4 0 10-6 0m6 0a4 4 0 016 3.46M9 11a4 4 0 00-6 3.46"/>
                                    </svg>
                                    Team
                                </a>
                                <a href="{{ route('crm.notifications.index') }}" class="crm-topbar-dd-item {{ request()->routeIs('crm.notifications.*') ? 'active' : '' }}" role="menuitem">
                                    <svg style="width:0.875rem;height:0.875rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0"/>
                                    </svg>
                                    Notifications
                                    @if($unreadNotifications > 0) <span class="crm-nav-badge">{{ $unreadNotifications }}</span> @endif
                                </a>
                                <a href="{{ route('crm.settings') }}" class="crm-topbar-dd-item {{ request()->routeIs('crm.settings') ? 'active' : '' }}" role="menuitem">
                                    <svg style="width:0.875rem;height:0.875rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Settings
                                </a>
                                <div class="crm-topbar-dd-sep"></div>
                                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="crm-topbar-dd-item crm-topbar-dd-item--danger" role="menuitem">
                                        <svg style="width:0.875rem;height:0.875rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
        <div style="background:#ecfdf3;border:1px solid #a7f3d0;color:#027a48;font-size:0.875rem;font-weight:500;padding:0.75rem 1.5rem;display:flex;align-items:center;gap:0.5rem;">
            <svg style="width:1rem;height:1rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div style="background:#fef3f2;border:1px solid #fecdca;color:#b42318;font-size:0.875rem;font-weight:500;padding:0.75rem 1.5rem;display:flex;align-items:center;gap:0.5rem;">
            <svg style="width:1rem;height:1rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Page content --}}
        <main class="crm-content crm-fade-in">
            {{ $slot }}
        </main>
    </div>

</div>

{{-- Sidebar + nav-group controllers — no Alpine dependency --}}
<script>
window.crmNavGroup = {
    toggle: function (btn) {
        var group = btn.closest('.crm-nav-group');
        var isOpen = group.getAttribute('data-open') === 'true';
        group.setAttribute('data-open', isOpen ? 'false' : 'true');
    }
};

window.crmSidebar = (function () {
    var KEY = 'crm_sidebar';
    var html = document.documentElement;

    function isOpen() {
        return html.classList.contains('crm-sb-open');
    }

    function set(open) {
        html.classList.toggle('crm-sb-open', open);
        try { localStorage.setItem(KEY, open ? '1' : '0'); } catch (e) {}
    }

    return {
        toggle: function () { set(!isOpen()); },
        open:   function () { set(true); },
        close:  function () { set(false); },
    };
})();
</script>

@stack('scripts')
</body>
</html>
