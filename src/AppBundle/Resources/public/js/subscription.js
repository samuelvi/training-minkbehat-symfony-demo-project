// Create a submitFormManager Class
function SubmitFormManager(data) {
    this.formId = data.formId;
    this.formValidationEnabled = true;
}

SubmitFormManager.prototype.initialize = function initialize() {
    this.submitFormListener();
};

SubmitFormManager.prototype.submitFormListener = function () {
    var that = this;
    $(document).on('submit', '[id^="' + this.formId + '"]', function (event) {

        canSubmit= (!that.formValidationEnabled || (that.formValidationEnabled && that.isValid()));

        if (canSubmit) {
            that.preSubmit($(this).attr('action'));
        }
        event.preventDefault();
    });
};

SubmitFormManager.prototype.getForm = function () {
    return $('#' + this.formId);
};

SubmitFormManager.prototype.isValid = function () {
    isValid = true;

    if ('' === this.getForm().find('#subscription_type_email').val()) {
        alert('You must fill in an e-mail');
        $('#subscription_type_email').focus();
        isValid = false;
    } else if (!this.getForm().find('#subscription_type_legal').prop('checked')) {
        alert('You must accept terms and conditions');
        isValid = false;
    } else if ('' === this.getForm().find('#subscription_type_fullname').val()) {
        alert('You must fill in a full name');
        $('#subscription_type_fullname').focus();
        isValid = false;
    }

    return isValid;
};

SubmitFormManager.prototype.submit = function submit(url) {
    var that = this;
    try {
        $.ajax({
            url: url,
            dataType: "json",
            data: this.getForm().serialize(),
            type: "POST",
            success: function (data) {
                $('#subscription_wrapper').html(data.response.view);
            },
            error: function (jxhr, textStatus, errorThrown) {
                alert(textStatus);
                alert(errorThrown);
            },
            complete: function () {
                $("#loader-wrapper").fadeToggle();
            }
        });
    } catch (error) {
        alert(error);
    }
};

SubmitFormManager.prototype.preSubmit = function preSubmit(url) {
    var that = this;
    closure = function () {
        // Wait 2 seconds for demo purposes
        setTimeout(function () {
            that.submit(url);
        }, 2000);
    };

    $("#loader-wrapper").fadeIn("fast", closure);
};
