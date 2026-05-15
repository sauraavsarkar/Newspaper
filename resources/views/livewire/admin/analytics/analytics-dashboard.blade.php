<x-slot name="header">
    <div class="flex items-center gap-3">
        <div class="h-8 w-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
            </svg>
        </div>
        <h2 class="font-bold text-2xl tracking-tight text-zinc-900 dark:text-white">Analytics</h2>
    </div>
</x-slot>

<div wire:poll.15s>
    {{-- Period Selector --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-2">
            <span class="text-sm text-zinc-500 font-medium">Period:</span>
            <select wire:model.live="period"
                class="bg-white dark:bg-zinc-900/50 border border-zinc-200 dark:border-white/10 rounded-xl px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="7">Last 7 days</option>
                <option value="14">Last 14 days</option>
                <option value="30">Last 30 days</option>
                <option value="90">Last 90 days</option>
            </select>
        </div>
        <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Live Data
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Views --}}
        <div class="glass-card rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-purple-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </div>
                <span
                    class="text-xs font-bold {{ $viewsGrowth >= 0 ? 'text-emerald-400 bg-emerald-400/10' : 'text-red-400 bg-red-400/10' }} px-2 py-1 rounded-lg">
                    {{ $viewsGrowth >= 0 ? '+' : '' }}{{ $viewsGrowth }}%
                </span>
            </div>
            <div class="text-3xl font-black text-zinc-900 dark:text-white mb-1">{{ number_format($periodViews) }}</div>
            <div class="text-zinc-500 text-sm font-medium">Period Views</div>
            <div class="text-xs text-zinc-400 mt-1">{{ number_format($totalViews) }} all time</div>
        </div>

        {{-- Published Articles --}}
        <div class="glass-card rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-zinc-900 dark:text-white mb-1">{{ $publishedArticles }}</div>
            <div class="text-zinc-500 text-sm font-medium">Published</div>
            <div class="text-xs text-zinc-400 mt-1">{{ $totalArticles }} total articles</div>
        </div>

        {{-- Unique Visitors --}}
        <div class="glass-card rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-pink-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-zinc-900 dark:text-white mb-1">{{ number_format($uniqueVisitors) }}
            </div>
            <div class="text-zinc-500 text-sm font-medium">Unique Visitors</div>
            <div class="text-xs text-zinc-400 mt-1">In selected period</div>
        </div>

        {{-- Avg Views Per Article --}}
        <div class="glass-card rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-orange-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-zinc-900 dark:text-white mb-1">{{ $avgViewsPerArticle }}</div>
            <div class="text-zinc-500 text-sm font-medium">Avg Views/Article</div>
            <div class="text-xs text-zinc-400 mt-1">{{ $draftArticles }} drafts, {{ $pendingArticles }} pending</div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        {{-- Views Over Time --}}
        <div class="lg:col-span-2 glass-card rounded-2xl p-6">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Views Over Time</h3>
            <div class="h-[300px]">
                <canvas id="viewsChart"></canvas>
            </div>
        </div>

        {{-- Category Breakdown --}}
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Category Performance</h3>
            <div class="h-[300px] flex items-center justify-center">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Bottom Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Top Articles --}}
        <div class="lg:col-span-2 glass-card rounded-2xl p-6">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Top Performing Articles</h3>
            <div class="space-y-3">
                @forelse($topArticles as $index => $article)
                    <div
                        class="flex items-center gap-4 p-3 rounded-xl {{ $index < 3 ? 'bg-indigo-500/5 border border-indigo-500/10' : 'hover:bg-zinc-100 dark:hover:bg-zinc-800/30' }} transition-colors">
                        <div
                            class="w-8 h-8 rounded-lg {{ $index === 0 ? 'bg-yellow-500/20 text-yellow-400' : ($index === 1 ? 'bg-zinc-300/20 text-zinc-400' : ($index === 2 ? 'bg-orange-500/20 text-orange-400' : 'bg-zinc-800/30 text-zinc-500')) }} flex items-center justify-center text-sm font-black shrink-0">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-white truncate">{{ $article->title }}
                            </h4>
                            <p class="text-xs text-zinc-500">by {{ $article->author?->name ?? 'Unknown' }} ·
                                {{ $article->category?->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-sm font-bold text-zinc-900 dark:text-white">
                                {{ number_format($article->period_views) }}</div>
                            <div class="text-xs text-zinc-500">{{ number_format($article->total_views) }} total</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-zinc-500">
                        <p>No articles with views yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-8">
            {{-- Top Authors --}}
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Top Authors</h3>
                <div class="space-y-4">
                    @forelse($topAuthors as $author)
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-indigo-500/20 shrink-0">
                                {{ substr($author->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white truncate">{{ $author->name }}
                                </p>
                                <p class="text-xs text-zinc-500">{{ $author->published_count }} articles</p>
                            </div>
                            <div class="text-sm font-bold text-zinc-900 dark:text-white">
                                {{ number_format($author->view_count) }} <span
                                    class="text-xs text-zinc-500 font-normal">views</span></div>
                        </div>
                    @empty
                        <p class="text-sm text-zinc-500 text-center py-4">No author data yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Devices --}}
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Device Distribution</h3>
                <div class="h-[150px]">
                    <canvas id="deviceChart"></canvas>
                </div>
            </div>

            {{-- Hourly Activity --}}
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Hourly Activity</h3>
                <div class="h-[150px]">
                    <canvas id="hourlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Views Feed --}}
    <div class="mt-8 glass-card rounded-2xl p-6">
        <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Live Reader Feed
        </h3>
        <div class="space-y-3">
            @forelse($recentViews as $view)
                <div
                    class="flex items-center gap-4 p-3 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800/30 transition-colors">
                    <div
                        class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-700 dark:text-white font-bold shrink-0">
                        {{ substr($view->user?->name ?? 'G', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-zinc-900 dark:text-zinc-300">
                            <span
                                class="font-semibold text-zinc-900 dark:text-white">{{ $view->user?->name ?? 'Guest' }}</span>
                            viewed
                            <span
                                class="font-semibold text-indigo-500 dark:text-indigo-400">{{ Str::limit($view->article?->title ?? 'Unknown', 40) }}</span>
                        </p>
                    </div>
                    <span class="text-xs text-zinc-500 shrink-0">{{ $view->viewed_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="text-sm text-zinc-500 text-center py-4">No views recorded yet.</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('livewire:navigated', initCharts);
        document.addEventListener('DOMContentLoaded', initCharts);

        function initCharts() {
            // Destroy existing charts
            Chart.helpers?.each(Chart.instances, (instance) => instance.destroy());

            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.06)';
            const textColor = isDark ? 'rgba(255,255,255,0.5)' : 'rgba(0,0,0,0.5)';

            // Views Over Time
            const viewsCtx = document.getElementById('viewsChart');
            if (viewsCtx) {
                new Chart(viewsCtx, {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Views',
                            data: @json($chartData),
                            borderColor: '#6366f1',
                            backgroundColor: isDark ? 'rgba(99,102,241,0.1)' : 'rgba(99,102,241,0.15)',
                            borderWidth: 2.5,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#6366f1',
                            pointBorderColor: isDark ? '#09090b' : '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 7,
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { color: gridColor }, ticks: { color: textColor, font: { size: 11 } } },
                            y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: textColor, font: { size: 11 }, precision: 0 } }
                        }
                    }
                });
            }

            // Category Doughnut
            const catCtx = document.getElementById('categoryChart');
            if (catCtx) {
                new Chart(catCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($categoryLabels),
                        datasets: [{
                            data: @json($categoryData),
                            backgroundColor: ['#6366f1', '#8b5cf6', '#a855f7', '#ec4899', '#f43f5e', '#f97316', '#eab308', '#22c55e'],
                            borderWidth: 0, hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: { legend: { position: 'bottom', labels: { color: textColor, padding: 12, font: { size: 11 }, usePointStyle: true, pointStyle: 'circle' } } }
                    }
                });
            }

            // Device Pie
            const deviceCtx = document.getElementById('deviceChart');
            if (deviceCtx) {
                new Chart(deviceCtx, {
                    type: 'pie',
                    data: {
                        labels: @json($deviceLabels),
                        datasets: [{
                            data: @json($deviceData),
                            backgroundColor: ['#6366f1', '#ec4899', '#f97316'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { position: 'right', labels: { color: textColor, font: { size: 10 }, boxWidth: 10 } } }
                    }
                });
            }

            // Hourly Bar
            const hourCtx = document.getElementById('hourlyChart');
            if (hourCtx) {
                new Chart(hourCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($hourlyLabels),
                        datasets: [{
                            data: @json($hourlyData),
                            backgroundColor: isDark ? 'rgba(99,102,241,0.4)' : 'rgba(99,102,241,0.6)',
                            borderRadius: 4, barPercentage: 0.6
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { display: false }, ticks: { color: textColor, font: { size: 9 }, maxTicksLimit: 12 } },
                            y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: textColor, font: { size: 10 }, precision: 0 } }
                        }
                    }
                });
            }
        }
    </script>
@endpush