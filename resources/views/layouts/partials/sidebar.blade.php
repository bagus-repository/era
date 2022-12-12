<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link{{ request()->is('/dashboard') ? ' active':'' }}" href="{{ route('home.index') }}">
                    <i class="nav-icon icon-speedometer"></i> Dashboard
                </a>
            </li>
            @if ($isAdmin)    
                <li class="nav-title">Master Data</li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link{{ request()->is('users*') ? ' active':'' }}" href="{{ route('users.index') }}">
                        <i class="nav-icon icon-puzzle"></i> Daftar Pengguna</a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link{{ request()->is('questions*') ? ' active':'' }}" href="{{ route('questions.index') }}">
                        <i class="nav-icon icon-puzzle"></i> Daftar Pertanyaan</a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link" href="{{ route('quizzes.index') }}">
                        <i class="nav-icon icon-puzzle"></i> Daftar Quiz</a>
                </li>
            @endif
        </ul>
    </nav>
</div>
