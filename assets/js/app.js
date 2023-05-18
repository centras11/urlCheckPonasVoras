import $ from 'jquery';
import Swal from 'sweetalert2';

global.$ = global.jQuery = $;

function profileDropdown() {
    let profile = $('.dashboard-header__profile');
    let profileMenu = $('.dashboard-header__profile-menu');

    profile.on('click', function () {
        profileMenu.toggle();
        if (profileMenu.css('display') === 'block') {
            $('.dashboard-header__profile-name svg').css('transform', 'rotate(90deg)');
        } else {
            $('.dashboard-header__profile-name svg').css('transform', 'rotate(270deg)');
        }
    });
}

function swalInit() {
    $('.js-delete-swal').on('click', function (e) {
        let that = this;
        e.preventDefault();
        Swal.fire({
            title: 'Do really you want to delete ? <br> That will erase related logs',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Don't delete`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: window.location.origin + $(that).attr('href'),
                    success: function (msg) {
                        location.reload()
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Link was not deleted', '', 'info')
            }
        })
    });
}

$(document).ready(function () {
    profileDropdown();
    swalInit();
});