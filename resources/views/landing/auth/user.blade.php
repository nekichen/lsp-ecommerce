<!-- Modal -->
<div class="modal fade" id="userProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Konten Profil Pengguna -->
                <div class="text-center">
                    <h3 class="mt-3">{{ Auth::user()->name }}</h3>
                    <p>Email: {{ Auth::user()->email }}</p>
                    <!-- Tambahkan informasi profil lainnya sesuai kebutuhan -->
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                    <a href="{{ route('profile') }}" class="user link-button">
                        <img src="{{ asset('assets/img/icon/edit.png') }}" alt="" class="change-profile">
                        Change Profile
                    </a>
                    <form action="{{ route('logout') }}" method="post" style="display:inline;">
                        @csrf
                        <button type="submit" class="log-out link-button">
                            Log out
                            <img src="{{ asset('assets/img/icon/log-out-red.png') }}" alt="" class="log-out">
                        </button>
                    </form>
                <!-- Tambahkan tombol atau fungsi lainnya di sini jika diperlukan -->
            </div>
        </div>
    </div>
</div>
