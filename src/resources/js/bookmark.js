window.addEventListener('DOMContentLoaded', function () {
    $(function () {
        let bookmark = $('.bookmark-toggle');
        let bookmarkBoardId;

        bookmark.on('click', function () {
            let $this = $(this);
            let icon = $this.children('i');
            bookmarkBoardId = $this.data('board-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url: `${bookmarkBoardId}/bookmark`,
                method: "POST",
                data: {
                    'board_id': bookmarkBoardId,
                },
            })
            .done(function () {
                $this.toggleClass('.bookmarked');
            })
        })
    })

});

