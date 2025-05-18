jQuery(function ($) {
  "use strict";
  const body = $("body");

  
  function handleLoginButtonState() {
    const agreementCheckbox = $("#agreement-checkbox");
    const loginButton = $(".login-btn");
    loginButton.on('click', function(e) {
      if (!agreementCheckbox.is(':checked')) {
        e.preventDefault();
       
        Swal.fire({
          icon: "warning",
          title: "خطا!",
          text: "لطفا با قوانین و مقررات موافقت کنید.",
          confirmButtonText: "باشه",
          target: ".wbs-popup-panel",
        });
        return false;
      }
      
    });
  }
  

  handleLoginButtonState();

  // Function to convert both Arabic and Persian digits to English
  function convertToEnglishDigits(str) {
    if (!str) return str;
    
    const digitMappings = {
      // Arabic digits
      "٠": "0",
      "٢": "2",
      "٣": "3",
      "٤": "4",
      "٥": "5",
      "٦": "6",
      "٧": "7",
      "٨": "8",
      "٩": "9",
      // Persian digits
      "۰": "0",
      "۱": "1",
      "۲": "2",
      "۳": "3",
      "۴": "4",
      "۵": "5",
      "۶": "6",
      "۷": "7",
      "۸": "8",
      "۹": "9"
    };
    
    let result = str.toString();
    for (let digit in digitMappings) {
      result = result.replace(new RegExp(digit, "g"), digitMappings[digit]);
    }
    return result;
  }

  // Define Persian and English digits arrays for reuse
  const persianDigits = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
  const englishDigits = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
  const arabicDigits = ["٠", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];

  function isSpecialKey(e) {
    return (
      e.key === "Backspace" ||
      e.key === "Delete" ||
      e.key === "Tab" ||
      e.key === "ArrowLeft" ||
      e.key === "ArrowRight" ||
      e.key === "Home" ||
      e.key === "End" ||
      e.ctrlKey ||
      e.metaKey
    );
  }

  function handlePersianDigitKeydown(e) {
    if (persianDigits.includes(e.key) || arabicDigits.includes(e.key)) {
      let englishDigit;
      if (persianDigits.includes(e.key)) {
        englishDigit = englishDigits[persianDigits.indexOf(e.key)];
      } else {
        englishDigit = englishDigits[arabicDigits.indexOf(e.key)];
      }
      const start = this.selectionStart;
      const end = this.selectionEnd;
      const value = this.value;
      this.value =
        value.substring(0, start) + englishDigit + value.substring(end);
      this.selectionStart = this.selectionEnd = start + 1;
      $(this).trigger("input");
      e.preventDefault();
      return false;
    }
    return true;
  }

  function handleNumericPaste(e, maxLength, allowDecimal = false) {
    let pastedData = e.originalEvent.clipboardData.getData("text");
    pastedData = convertToEnglishDigits(pastedData);
    pastedData = pastedData.replace(allowDecimal ? /[^\d.]/g : /\D/g, "");
    if (allowDecimal) {
      const parts = pastedData.split(".");
      if (parts.length > 2) {
        pastedData = parts[0] + "." + parts.slice(1).join("");
      }
      if (parts.length === 2) {
        pastedData = parts[0].substring(0, 2) + "." + parts[1].substring(0, 2);
      } else {
        pastedData = pastedData.substring(0, 2);
      }
    } else {
      pastedData = pastedData.substring(0, maxLength);
    }
    $(this).val(pastedData);
    e.preventDefault();
    $(this).trigger("input");
  }

  function setupNumericField(selector, options) {
    const field = $(selector);
    const defaultOptions = {
      maxLength: 10,
      pattern: /^\d*$/,
      errorMessage: "لطفا فقط عدد وارد کنید",
      allowDecimal: false,
      validateOnBlur: true,
      clearErrorOnInput: true,
    };
    options = { ...defaultOptions, ...options };
    
    field.on("keydown", function (e) {
      if (isSpecialKey(e)) {
        return true;
      }
      if (e.code.startsWith("Numpad") && e.key >= "0" && e.key <= "9") {
        return true;
      }
      if (!handlePersianDigitKeydown.call(this, e)) {
        return false;
      }
      if (options.allowDecimal && (e.key === "." || e.key === "/")) {
        if (this.value.includes(".")) {
          e.preventDefault();
          return false;
        }
        if (e.key === "/") {
          const start = this.selectionStart;
          const end = this.selectionEnd;
          const value = this.value;
          this.value = value.substring(0, start) + "." + value.substring(end);
          this.selectionStart = this.selectionEnd = start + 1;
          $(this).trigger("input");
          e.preventDefault();
          return false;
        }
        return true;
      }
      if (englishDigits.includes(e.key)) {
        if (
          this.value.length >= options.maxLength &&
          this.selectionStart === this.selectionEnd
        ) {
          e.preventDefault();
          return false;
        }
        if (options.handleDigit) {
          return options.handleDigit.call(this, e);
        }
        return true;
      }
      e.preventDefault();
      return false;
    });

    field.on("paste", function (e) {
      handleNumericPaste.call(this, e, options.maxLength, options.allowDecimal);
    });

    if (options.validateOnBlur) {
      field.on("blur", function () {
        let value = $(this).val();
        if (value) {
          value = convertToEnglishDigits(value).replace(/\D/g, "");
          $(this).val(value);
          let isValid = true;
          let errorMessage = options.errorMessage;
          if (options.validateFunction) {
            const result = options.validateFunction.call(this, value);
            if (result !== true) {
              isValid = false;
              errorMessage = result || options.errorMessage;
            }
          }
          if (!isValid) {
            $(this).addClass("input-error");
            this.setCustomValidity(errorMessage);
            this.reportValidity();
          } else {
            $(this).removeClass("input-error");
            this.setCustomValidity("");
          }
        }
      });
    }

    if (options.onInput) {
      field.on("input", options.onInput);
    }

    return field;
  }

  // Setup mobile input field
  setupNumericField("input#mobile", {
    maxLength: 11,
    pattern: /^\d{0,11}$/,
    errorMessage: "شماره موبایل باید دقیقاً ۱۱ رقم باشد.",
    validateFunction: function (value) {
      const startsWithCorrectPrefix = value.startsWith("09");
      const hasCorrectLength = value.length === 11;
      if (!startsWithCorrectPrefix && !hasCorrectLength) {
        return "شماره موبایل باید با ۰۹ شروع شود و دقیقاً ۱۱ رقم باشد.";
      } else if (!startsWithCorrectPrefix) {
        return "شماره موبایل باید با ۰۹ شروع شود.";
      } else if (!hasCorrectLength) {
        return "شماره موبایل باید دقیقاً ۱۱ رقم باشد.";
      }
      return true;
    },
  });

  // Setup verification code input field
  setupNumericField("input#code", {
    maxLength: 5,
    pattern: /^\d{0,5}$/,
    errorMessage: "کد تایید باید عدد باشد.",
  });

  body.on("submit", "#loginForm", function () {
    const _this = $(this),
      phone = convertToEnglishDigits($("input#mobile").val().trim());
    if (phone === "") {
      Swal.fire({
        icon: "warning",
        title: "خطا!",
        text: "لطفا شماره موبایل خود را وارد نمایید!",
        confirmButtonText: "باشه",
        target: ".wbs-popup-panel",
      });
      return false;
    }
    _this.find('button[type="submit"]').css("background-color", "#c2bbbb");
    
    wbs_loading_start(_this.find('button[type="submit"]'), 'small', 'button-loader');
    
    // wbsAjax
    wbsAjax(
      "submitLoginForm", 
      { phone: phone }, 
      "json",
      function(res) {
        if (res.status === "error") {
          Swal.fire({
            icon: "warning",
            title: "خطا!",
            text: res.message,
            confirmButtonText: "باشه",
            target: ".wbs-popup-panel",
          });
          _this.find('button[type="submit"]').css("background-color", "");
          wbs_loading_end(_this.find('button[type="submit"]'));
          return false;
        } else if (res.status === "success") {

        $(".loginContainer").html(res.content);
/*
        wbsTimer(10, document.querySelector('.timer'), function () {
          $('.timer').replaceWith('<span class="timer">ارسال مجدد کد</span>');
        });
        */
      }
       wbs_loading_end(_this.find('button[type="submit"]'));
      },
      function (error) {
        // Handle AJAX failure
        Swal.fire({
          icon: "error",
          title: "خطا!",
          text: "خطا در ارتباط با سرور. لطفا دوباره تلاش کنید.",
          confirmButtonText: "باشه",
          target: ".wbs-popup-panel",
        });

        _this.find('button[type="submit"]').css("background-color", "");
        wbs_loading_end(_this.find('button[type="submit"]'));
      },
      function() {
        // عملیات تکمیلی در صورت نیاز
      }
    );
    
    return false;
  });

  body.on("submit", "#verifyForm", function () {
    const _this = $(this),
      code = convertToEnglishDigits($("input#code").val().trim());

    if (code === "") {
      Swal.fire({
        icon: "warning",
        title: "خطا!",
        text: "لطفا کد تایید را وارد نمایید!",
        confirmButtonText: "باشه",
        target: ".wbs-popup-panel",
      });
      return false;
    }

    _this.find('button[type="submit"]').css("background-color", "#c2bbbb");
    wbs_loading_start(_this.find('button[type="submit"]'), 'small', 'button-loader');
    
    // wbsAjax
    wbsAjax(
      "submitVerifyForm", 
      { code: code }, 
      "json",
      function(res) {
        if (res.status === "error") {
          _this.find('button[type="submit"]').css("background-color", "");
          wbs_loading_end(_this.find('button[type="submit"]'));
          Swal.fire({
            icon: "warning",
            title: "خطا!",
            text: res.message,
            confirmButtonText: "باشه",
            target: ".wbs-popup-panel",
          });
          
          
          if (res.redirect === true) {
            setTimeout(function() {
              
              $(".loginContainer").load(window.location.href + " .loginContainer > *", function() {
                
                handleLoginButtonState();
              });
            }, 2000); 
          }
          
          return false;
        }
        window.location.href = res.url;
      },
      function(error) {
        _this.find('button[type="submit"]').css("background-color", "");
        wbs_loading_end(_this.find('button[type="submit"]'));
        Swal.fire({
          icon: "error",
          title: "خطا!",
          text: "خطا در ارتباط با سرور",
          confirmButtonText: "باشه",
          target: ".wbs-popup-panel",
        });
      },
      function() {
        // عملیات تکمیلی در صورت نیاز
      }
    );
    
    return false;
  });
});