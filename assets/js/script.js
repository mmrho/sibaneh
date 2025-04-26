// JavaScript Document
jQuery(function ($) {
    "use strict";
    const body = $('body');
    let xhr;
    var swiper = new Swiper("#homeSlider", {
        slidesPerView: 1,
        spaceBetween: 40,
        loop: false,
        speed: 700
    });

    $('#res-menu-btn').click(function () {
        $('.hew-res-sidebar-panel').fadeIn('normal', function () {
            $('.hew-res-sidebar').css('right', 0);
        });
    });

    $('#close-res-menu').click(function () {
        $('.hew-res-sidebar').css('right', '-100%');
        $('.hew-res-sidebar-panel').fadeOut();
    });

    $(document).mouseup(function (e) {
        var container = $(".hew-res-sidebar");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('.hew-res-sidebar').css('right', '-100%');
            $('.hew-res-sidebar-panel').fadeOut('normal');
        }
    });

    body.on('click', '.top-person-panel .top-person-tabs li:not(.active)', function () {
        const _this = $(this);
        $('.top-person-panel .top-person-tabs li').removeClass('active');
        _this.addClass('active');
        $('.top-person-panel .top-person-box').fadeOut('fast', function () {
            setTimeout(function () {
                $('.top-person-panel .top-person-box#' + _this.attr('data-target')).fadeIn('normal');
            }, 120);
        });
    });

    if ($(window).width() <= 800) {
        $('.sidebar-p').addClass('close');
        $('.content-p').addClass('full');
        $('#open-sidebar').show();
    }

    //$(".dashboard-menu ul").mCustomScrollbar();

    body.on('click', '.dashboard-sidebar #sidebar-btn', function () {
        $('.sidebar-p').addClass('close');
        $('.content-p').addClass('full');
        $('#open-sidebar').fadeIn();
    });

    body.on('click', '#dashboard-main #open-sidebar', function () {
        $('#open-sidebar').hide();
        $('.sidebar-p').removeClass('close');
        $('.content-p').removeClass('full');
    });

    $('.dashboard-menu ul li').click(function (e) {
        const _this = $(this);
        _this.find('> ul.sub-menu').stop(true, true).slideToggle();
    });

    body.on('submit', '#attendance', function () {
        const students = $('.studentInput').serialize();
        wbs_loading_start('#attendance');
        wbsAjax('saveClassRoomAttendance', {students: students}, 'json', function (res) {
            Swal.fire({
                icon: 'success',
                title: 'موفق',
                text: res.message,
                confirmButtonText: 'متوجه شدم',
            });
            $('#attendanceID').val(res.id);
            wbs_loading_end();
        });
        return false;
    });

    body.on('submit', '#updateAttendance', function () {
        const students = $('.studentInput').serialize(), attendanceID = $('#attendanceID').val();
        wbs_loading_start('#updateAttendance');
        wbsAjax('updateClassRoomAttendance', {students: students, attendanceID: attendanceID}, 'json', function (res) {
            Swal.fire({
                icon: 'success',
                title: 'موفق',
                text: res.message,
                confirmButtonText: 'متوجه شدم',
            });
            wbs_loading_end();
        });
        return false;
    });

    if ($('.time-left').length > 0) {
        const face = $('.time-left').attr('data-type');
        countDown('.time-left', {
            clockFace: face,
            autoStart: true,
            countdown: true,
            language: 'persian',
            callbacks: {
                stop: function () {
                    wbs_loading_start('.hew-card .class-data');
                    let status = 'started';
                    if (face === 'dailyCounter') {
                        status = 'notStarted';
                    }
                    wbsAjax('onlineBegin', {
                        id: $('.time-left').attr('data-id'),
                        status: status,
                    }, 'json', function (res) {
                        if (res.status === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطا!',
                                text: res.message,
                                target: '.wbs-popup',
                                confirmButtonText: 'تلاش مجدد'
                            });
                            wbs_loading_end();
                            return false;
                        }
                        $('.class-data').html(res.content);
                        countDown('.time-left', {
                            clockFace: 'hourlyCounter',
                            autoStart: true,
                            countdown: true,
                            language: 'persian',
                            callbacks: {
                                stop: function () {
                                    $('.class-data').html('<p style="font-size: 15px; color: #ff0000">متاسفانه تایم مجاز برای حضور در کلاس به پایان رسیده و شما از کلاس جا\n' +
                                        '            مانده اید.</p>');
                                    wbs_loading_end();
                                }
                            }
                        });
                        wbs_loading_end();
                    });
                }
            }
        });
    }

    if ($('.quiz-timer').length > 0) {
        const face = $('.quiz-timer').attr('data-type'), status = $('.quiz-timer').attr('data-status');
        countDown('.quiz-timer', {
            clockFace: face,
            autoStart: true,
            countdown: true,
            language: 'persian',
            callbacks: {
                stop: function () {
                    wbs_loading_start('.box-panel.quiz-content');
                    wbsAjax('getQuiz', {
                        id: $('.quiz-timer').attr('data-id'),
                        status: status
                    }, 'json', function (res) {
                        $('.quiz-content').replaceWith(res.content);
                        wbs_loading_end();
                    });
                }
            }
        });
    }

    body.on('click', '.add-new-assign button ', function () {
        const total = $('.assign-list ul li').length + 1, structure = '<li>\n' +
            '                                <fieldset>\n' +
            '                                    <label>عنوان</label>\n' +
            '                                    <input class="form-control wbsAssign" type="text" name="assign[' + total + '][title]"/>\n' +
            '                                </fieldset>\n' +
            '                                <fieldset>\n' +
            '                                    <label>فایل</label>\n' +
            '                                    <input class="form-control wbsAssignFile" type="file" />\n' +
            '                                    <input class="fileID wbsAssign" name="assign[' + total + '][fileID]" type="hidden"/>' +
            '<div class="uploadStat"><span class="stat"></span><span class="bar"></span></div> \n' +
            '                                </fieldset>\n' +
            '                                <fieldset>\n' +
            '                                    <label>توضیحات</label>\n' +
            '                                    <textarea class="form-control wbsAssign" name="assign[' + total + '][description]"></textarea>\n' +
            '                                </fieldset>\n' +
            '                                <fieldset>\n' +
            '                                    <span class="remove-item">×</span>\n' +
            '                                </fieldset>\n' +
            '                            </li>';
        $('.assign-list ul').append(structure);
        if ($('.assign-list .save-assign button').hasClass('btn-secondary')) {
            $('.assign-list .save-assign button').removeAttr('disabled').removeClass('btn-secondary').addClass('btn-primary');
        }
    });

    body.on('click', '.assign-list .remove-item', function () {
        const _this = $(this);
        Swal.fire({
            title: 'اخطار',
            text: "آیا از حذف مورد انتخابی مطمئن هستید؟",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله',
            cancelButtonText: 'لفو'
        }).then((result) => {
            if (result.isConfirmed) {
                wbsAjax('removeAssignItem',
                    {id: _this.attr('data-id')}, 'json', function (res) {
                        _this.parents('li').remove();
                    });
            }
        });
    });

    body.on('change', '.wbsAssignFile', function () {
        const _this = $(this), file = _this[0];
        let isAnswer = false,
            data = {
                object: 'attendance',
                objectID: $('#attendanceID').val(),
                lessonID: $('input#lessonID').val(),
                classID: $('input#classID').val()
            };

        if (_this.attr('data-type') !== '' && _this.attr('data-type') === 'answer') {
            isAnswer = true;
            data.isAnswer = isAnswer;
            data.object = 'answer';
            data.objectID = _this.attr('data-item');
        }

        var fileExtension = ['zip', 'jpeg', 'jpg', 'png', 'pdf'];
        if ($.inArray(_this.val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            Swal.fire({
                icon: 'error',
                title: 'خطا!',
                text: 'فرمت فایل انتخابی نامعتبر است.',
                target: 'body',
                confirmButtonText: 'متوجه شدم'
            });
            _this.val('');
            return false;
        }

        if (file.files[0].size > 20971520 || file.files[0].fileSize > 20971520) {
            Swal.fire({
                icon: 'error',
                title: 'خطا!',
                text: 'حجم فایل نبایستی بیش از 20 مگابایت باشد.',
                target: 'body',
                confirmButtonText: 'متوجه شدم'
            });
            _this.val('');
            return false;
        }
        uploadFileAjax(file, 'uploadAttendanceFile', data, function (res) {
            if (res.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: res.message,
                    target: 'body',
                    confirmButtonText: 'متوجه شدم'
                });
                _this.val('');
                return false;
            }
            if (isAnswer) {
                if (res.status === 'completed') {
                    _this.parents('tr').find('.status').replaceWith('<span class="status isBtn awaiting">در انتظار بررسی</span>');
                }
                return false;
            }
            _this.parent().find('input.fileID').attr('value', res.id);
        });
    });

    body.on('submit', '#assignmentForm', function () {
        if ($('#attendanceID').val() === '') {
            Swal.fire({
                icon: 'error',
                title: 'خطا!',
                text: 'ابتدا بایستی لیست حضور و غیاب را ذخیره نمایید.',
                target: 'body',
                confirmButtonText: 'متوجه شدم'
            });
            return false;
        }
        const _this = $(this);
        wbsAjax('saveAssignData', {data: _this.serialize()}, 'json', function (res) {
            Swal.fire({
                title: 'موفق',
                text: res.message,
                icon: 'success',
                confirmButtonText: 'متوجه شدم',
            }).then((result) => {
                window.location.reload();
            });

        });
        return false;
    });

    body.on('click', '.wbs-dropdown ul li header', function () {
        const _this = $(this);
        if (!_this.parent().hasClass('open')) {
            $('.wbs-dropdown ul li').removeClass('open');
            $('.wbs-dropdown ul li footer').slideUp();
            _this.parent().addClass('open').find('footer').stop(true, true).slideDown();
            return false;
        }

        $('.wbs-dropdown ul li').removeClass('open');
        $('.wbs-dropdown ul li footer').stop(true, true).slideUp();
    });

    body.on('change', '.quiz-form select#class_id', function () {
        const _this = $(this);
        $('select#lesson_id').html('<option value="">انتخاب کنید...</option>').attr('disabled', 'disabled');
        wbsAjax('getTeacherClassRoomsLessons', {classID: _this.val()}, 'json', function (res) {
            if (res.options.length === 0) {
                $('select#lesson_id').html('<option>موردی یافت نشد!</option>');
                return false;
            }
            $.each(res.options, function (key, value) {
                $('select#lesson_id').append(new Option(value[1], value[0]));
            });
            $('select#lesson_id').removeAttr('disabled');
        });
    });

    body.on('submit', '#createQuiz', function () {
        const _this = $(this);
        wbs_loading_start('.quiz-panel');
        wbsAjax('createQuiz', {inputs: _this.serialize()}, 'json', function (res) {
            if (res.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: res.message,
                    target: 'body',
                    confirmButtonText: 'متوجه شدم'
                });
                return false;
            }
            window.location.href = wbsChangeUrl('action', 'questions') + '&quiz=' + res.id;
        });
        return false;
    });

    if ($('#start_at').length > 0) {
        new mds.MdsPersianDateTimePicker(document.getElementById('start_at'), {
            targetTextSelector: '#start_at',
            targetDateSelector: '#start_at_en',
            enableTimePicker: true,
            selectedDate: $('#start_at_en').val() !== '' ? new Date($('#start_at_en').val()) : ''
        });

    }

    body.on('click', '.deleteItem', function () {
        if (confirm("آیا از حذف مورد انتخابی مطمئن هستید؟") !== true) {
            return false;
        }
    });

    body.on('submit', '#updateQuiz', function () {
        const _this = $(this);
        wbs_loading_start('.quiz-panel');
        wbsAjax('updateQuiz', {inputs: _this.serialize()}, 'json', function (res) {
            if (res.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: res.message,
                    target: 'body',
                    confirmButtonText: 'متوجه شدم'
                });
                return false;
            }
            window.location.href = wbsChangeUrl('action', 'questions');
        });
        return false;
    });

    body.on('click', '#addQuestionItem', function () {
        const total = $('.profile-table tbody tr').length + 1;
        wbs_loading_start('.table-responsive');
        wbsAjax('addQuestionItem', {questionID: $(this).attr('data-id')}, 'json', function (res) {
            const newStructure = '<tr>\n' +
                '                            <td>' + total + '</td>\n' +
                '                            <td><input required type="text" name="items[' + total + '][title]" class="form-control questionInput"/></td>\n' +
                '                            <td><input value="' + res.id + '" type="checkbox" name="correct"\n' +
                '                                       class="correctInput"/><input type="hidden" name="items[' + total + '][id]" value="' + res.id + '" /> </td>\n' +
                '                            <td class="action"><span data-id="' + res.id + '" class="cancelItem"><i class="icon-cancel"></i></span></td>\n' +
                '                        </tr>';
            $('.profile-table tbody').append(newStructure);
            wbs_loading_end();
        });
    });

    body.on('click', '.correctInput', function () {
        $('.correctInput').prop('checked', false);
        $(this).prop('checked', true);
    });

    body.on('click', '.cancelItem', function () {
        const _this = $(this);
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: "این عمل غیر قابل بازگشت است!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله مطمئنم',
            cancelButtonText: 'لغو'
        }).then((result) => {
            if (result.isConfirmed) {
                if (_this.attr('data-id') !== undefined) {
                    wbsAjax('removeQuestionItem', {id: _this.attr('data-id')}, 'json', function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'موفق!',
                            text: res.message,
                            target: 'body',
                            confirmButtonText: 'متوجه شدم'
                        });
                        _this.parents('tr').remove();
                    });
                } else {
                    _this.parents('tr').remove();
                }
            }
        })

    });

    body.on('submit', '#createQuestion', function () {
        const _this = $(this);
        wbs_loading_start('.quiz-panel');
        wbsAjax('createQuestion', {quizID: _this.attr('data-id'), inputs: _this.serialize()}, 'json', function (res) {
            if (res.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: res.message,
                    target: 'body',
                    confirmButtonText: 'متوجه شدم'
                });
                return false;
            }
            _this[0].reset();
            Swal.fire({
                icon: 'success',
                title: 'موفق!',
                text: 'پرسش با موفقیت ایجاد گردید!',
                target: 'body',
                confirmButtonText: 'متوجه شدم'
            });
            wbs_loading_end();
        });
        return false;
    })

    body.on('submit', '#updateQuestion', function () {
        const _this = $(this);
        wbs_loading_start('.quiz-panel');
        wbsAjax('updateQuestion', {quizID: _this.attr('data-id'), inputs: _this.serialize()}, 'json', function (res) {
            wbs_loading_end();
            if (res.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: res.message,
                    target: 'body',
                    confirmButtonText: 'متوجه شدم'
                });
                return false;
            }
            Swal.fire({
                icon: 'success',
                title: 'موفق!',
                text: 'پرسش با موفقیت به روز رسانی گردید!',
                target: 'body',
                confirmButtonText: 'متوجه شدم'
            }).then((result) => {
                window.location.href = wbsChangeUrl('item', _this.attr('data-question'));
            });
        });
        return false;
    });

    body.on('click', '#beginQuiz', function () {
        wbs_loading_start('.quiz-content');
        wbsAjax('startQuiz', {id: $(this).attr('data-id')}, 'json', function (res) {
            $('.quiz-content').replaceWith(res.content);
            wbs_loading_end();
        });
        return false;
    });

    body.on('submit', '#saveQuizData', function () {
        const _this = $(this);
        wbs_loading_start(_this);
        wbsAjax('saveQuizData', {items: _this.serialize()}, 'json', function (res) {
            console.log(res);
            if (res.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: res.message,
                    target: 'body',
                    confirmButtonText: 'تلاش مجدد'
                });
                wbs_loading_end();
                return false;
            }
            wbs_loading_end();
            Swal.fire({
                icon: 'success',
                title: 'آزمون شما با موفقیت به پایان رسید.',
                text: 'تا دقایقی دیگر نتیجه آزمون خود را مشاهده خواهید شد.',
                confirmButtonText: 'متوجه شدم',
            }).then((result) => {
                wbs_loading_start('.quiz-content');
                wbsAjax('getAttendResult',
                    {id: res.attend_id}, 'json', function (res) {
                        $('.quiz-content').replaceWith(res.content);
                        wbs_loading_end();
                    });
            });
        });
        return false;
    });

    body.on('click', '.assign-items table td.actions span', function () {
        const _this = $(this);
        let status = 'approve';

        if (_this.hasClass('notApprove')) {
            status = 'notApprove';
        }

        Swal.fire({
            input: 'textarea',
            inputLabel: 'توضیحات',
            inputPlaceholder: 'اگر توضیحی دارید بنویسید...',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'ذخیره',
            denyButtonText: 'انصراف',
        }).then((result) => {
            if (result.isConfirmed) {
                const id = _this.parent().attr('data-id');
                wbs_loading_start(_this.parents('li.open'));
                wbsAjax('saveAssignAction', {id: id, status: status, message: result.value}, 'json', function (res) {
                    if (res.status === 'error') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'خطا!',
                            text: res.message,
                            confirmButtonText: 'باشه',
                        });
                        wbs_loading_end();
                        return false;
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'موفق',
                        text: res.message,
                        confirmButtonText: 'متوجه شدم',
                    });
                    if (status === 'approve') {
                        _this.parents('tr').find('.status-panel').html('<span class="status isBtn completed">تایید شده</span>');
                    } else {
                        _this.parents('tr').find('.status-panel').html('<span class="status isBtn failed">رد شده</span>');
                    }
                    wbs_loading_end();
                });
            }
        })

    });

    body.on('keyup', '.online-price .price input', function () {
        const _this = $(this), normal = _this.val().replace(/,/g, ''),
            floated = parseFloat(normal).toLocaleString('en');
        _this.val(floated);
    });

    body.on('submit', '#counselingForm', function () {
        const _this = $(this);
        wbs_loading_start('.counseling-panel');
        wbsAjax('createCounseling', {title: $('#title').val(), message: $('#message').val()}, 'json', function (res) {
            if (res.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: res.message,
                    target: 'body',
                    confirmButtonText: 'متوجه شدم'
                });
                wbs_loading_end();
                return false;
            }
            Swal.fire({
                icon: 'success',
                title: 'موفق',
                text: res.message,
                confirmButtonText: 'متوجه شدم',
            });
            _this[0].reset();
            wbs_loading_end();
        });

        return false;
    });

    body.on('click', '.complete-counseling #completeCounseling', function () {
        const _this = $(this);
        wbs_loading_start('.counseling-panel');
        Swal.fire({
            title: 'اخطار',
            text: "آیا از تکمیل کردن درخواست مورد نظر مطمئن هستید؟",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله مطمئن هستم',
            cancelButtonText: 'لفو'
        }).then((result) => {
            if (result.isConfirmed) {
                wbsAjax('completeCounseling', {id: _this.attr('data-id')}, 'json', function (res) {
                    if (res.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا!',
                            text: res.message,
                            target: 'body',
                            confirmButtonText: 'متوجه شدم'
                        });
                        wbs_loading_end();
                        return false;
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'موفق',
                        text: res.message,
                        confirmButtonText: 'متوجه شدم',
                    });
                    _this.replaceWith('<span class="text-success">این درخواست چند ثانیه پیش تکمیل گردید.</span>');
                    wbs_loading_end();
                });
            }
        });
    });

    function max(value, max) {
        if (parseInt(value) > max) {
            return true;
        }

        return false;
    }


    function uploadFileAjax(input, action, data = {}, completeCallback = null) {
        const _this = $(input);
        var bar = _this.parent().find('.uploadStat .bar');
        var status = _this.parent().find('.uploadStat .stat');
        var formdata = new FormData();
        formdata.append('file', input.files[0]);
        formdata.append('data', JSON.stringify(data));
        formdata.append('action', action);
        formdata.append('security', wbs_script.SecurityNonce);
        bar.attr('class', 'bar');
        $.ajax({
            url: wbs_script.AjaxUrl,
            type: "POST",
            data: formdata,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (res) {
                completeCallback(res);
                if (res.status !== 'error') {
                    bar.width('100%').addClass('complete');
                    return false;
                }
                bar.width('100%').addClass('error');
            },
            beforeSend: function () {
                bar.css('width', '0%');
            },
            error: function () {
                bar.addClass('error');
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100) - 10;
                        bar.css('width', percentComplete + '%');

                    }
                }, false);

                return xhr;
            }
        });
    }
});
