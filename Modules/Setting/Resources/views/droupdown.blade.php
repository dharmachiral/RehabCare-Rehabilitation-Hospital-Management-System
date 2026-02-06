<div class="header-right">
    <div class="user-profile">
        <div class="dropdown-trigger">
            @if(auth()->user()->image)
                <img src="{{ asset('upload/images/users/'.auth()->user()->image) }}" alt="User Photo">
            @else
                <div class="no-avatar" style="width: 40px; height: 40px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <span>{{ Auth::user()->name }}</span>
        </div>

        <div class="dropdown-menu">
            <a href="{{ route('profile.edit') }}" target="_blank"><i class="fas fa-user"></i> My Profile</a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dropdown functionality
    const dropdownTrigger = document.querySelector('.dropdown-trigger');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    
    if (dropdownTrigger && dropdownMenu) {
        // Toggle dropdown on click
        dropdownTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdownTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });

        // Close dropdown when clicking on a dropdown item
        dropdownMenu.addEventListener('click', function(e) {
            if (e.target.tagName === 'A') {
                dropdownMenu.classList.remove('show');
            }
        });
    }

    // Tooltips for action buttons
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            const title = this.getAttribute('title');
            if (title) {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.textContent = title;
                this.appendChild(tooltip);

                setTimeout(() => {
                    if (this.contains(tooltip)) {
                        this.removeChild(tooltip);
                    }
                }, 2000);
            }
        });
    });

    // Logout confirmation
    const logoutLink = document.querySelector('.dropdown-menu a[href="{{ route('logout') }}"]');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to logout?')) {
                e.preventDefault();
            }
        });
    }
});
</script>
<style>
    .user-profile {
    position: relative;
    display: inline-block;
}

.dropdown-trigger {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    padding: 8px;
    border-radius: 4px;
}

.dropdown-trigger:hover {
    background-color: #f5f5f5;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    min-width: 150px;
    z-index: 1000;
    display: none;
    flex-direction: column;
}

.dropdown-menu.show {
    display: flex;
}

.dropdown-menu a {
    padding: 10px 15px;
    text-decoration: none;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
    border-bottom: 1px solid #eee;
}

.dropdown-menu a:last-child {
    border-bottom: none;
}

.dropdown-menu a:hover {
    background-color: #f5f5f5;
}

.no-avatar {
    width: 40px;
    height: 40px;
    background: #eee;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>