/**
 * Created by Greg.Goldfarb on 7/1/17.
 */
var BannerForm = {
    /*
     * @form is the form object
     * @validImgWidths accepts an object of valid widths for each adaptive banner type of
     * single, double, and triple
     *      {
                 single: [1008, 1260, 1512, 1764],
                 double: [500, 624, 752, 878],
                 triple: [420, 630]
             };
     */

    initiate: function(form, validImgWidths) {
        /*
         *  Created objects for the form fields to be accessible outside of scope.
         */
        BannerForm.formFields = form.find('input').not('input[type="hidden"]');
        BannerForm.textFields = form.find('input[type="text"]').not('input[type="hidden"]');

        /*
         *  SETUP THE DATEPICKER WITH CORRECT FORMAT
         */
        $( "#release-date" ).datepicker({"dateFormat":"yymmdd" });

        /*
         *  THIS IS SO WE CAN MANUALLY CREATE THE CUSTOM DROPZONE.
         *  DO NOT REMOVE THIS
         */
        Dropzone.autoDiscover = false;

        /*
         *  THIS STARTS THE FORM PROCESS OF CHOOSING THE BANNER TYPE
         */
        $('#banner-type').change(function(){
            var bannerType = $(this).val(),
                dz = $('.dz'),
                formSubmitBtns = $('.form-submit'),
                removeButton = $('#remove-files'),
                validBannerImgWidths = validImgWidths[bannerType];

            if(bannerType === "null") {
                $(dz,'#generic-form-fields').addClass('hidden');
                formSubmitBtns.addClass('hidden');
                removeButton.addClass('hidden');
                formSubmitBtns.attr('disabled', 'disabled');
            } else{
                $('#generic-form-fields').removeClass('hidden');
                BannerForm.setupDropZone(bannerType, dz, formSubmitBtns, removeButton, validBannerImgWidths);
            }
        });


        /*
         * LISTENER FOR ALL FORM FIELDS FOR VALIDATION PURPOSES
         */
        $(BannerForm.formFields).on('keyup blur change keypress paste', function(e){
            if(e.keyCode === 13){
                e.preventDefault();
            }
            var bannerType = $('#banner-type').val(),
                validBannerImgWidths = Validate.getValidBannerImgWidths(bannerType, validImgWidths);
            Validate.form(bannerType, validBannerImgWidths, BannerForm.formFields, BannerForm.textFields);
        });

        /*
         * TOGGLE WHETHER THE BANNER CONTAINS A CLICKABLE LINK
         */
        BannerForm.setupCTA($('#clickable'), $('.cta-url-container'));
    },

    /*
     * @setupCTA is a function that sets up the CTA URL inputs for clickable banners
     */
    setupCTA: function (clickable, ctaURLContainer) {
        if(clickable.is('checked')){
            ctaURLContainer.removeClass('hidden');
        } else {
            ctaURLContainer.addClass('hidden');
        }

        clickable.change( function () {
            ctaURLContainer.toggleClass('hidden');
        });
    },

    /*
     * @setupDropZone is a function that creates the dropzones for each banner type.
     * @bannerType accepts a string of 'single, double, or triple'
     * @dz is an object of all dropzone outer containers $('.dz')
     * @formSubmitBtns is an object of each submit button associated with each banner type
     * @removeButton is an object for the REMOVE ALL FILES BUTTON
     * @validBannerImgWidths is ARRAY of valid banner widths that go with the banner type
     */
    setupDropZone: function (bannerType, dz, formSubmitBtns, removeButton, validBannerImgWidths) {
        /*
         * @validNumberImgs gets the total number of images for each banner in order to
         * be set as an @maxFiles option in DROPZONE (see @BannerForm.activateDropzone)
         */
        var validNumberImgs = validBannerImgWidths.length;

        /*
         *  HIDE/SHOW Remove All Files button which removes all files from all dropzones
         */
        if(removeButton.hasClass('hidden')){
            removeButton.removeClass('hidden');
        }

        dz.addClass('hidden');
        formSubmitBtns.addClass('hidden');

        /*
         * DISPLAY THE ACTIVE BANNER TYPE CONTAINER
         */
        $('#form-submit-' + bannerType).removeClass('hidden');


        /*
         *  DETERMINE THE DROPZONES THAT GO WITH THE SELECTED BANNER TYPE TO ACTIVATE
         */
        switch(bannerType) {
            case 'single':
                var singleBanner = BannerForm.activateDropzone(bannerType,'left',validNumberImgs, validBannerImgWidths),
                    single = {
                        type : bannerType,
                        single : singleBanner
                    };
                BannerForm.submit(single);
                break;
            case 'double':
                var left = BannerForm.activateDropzone(bannerType, 'left', validNumberImgs, validBannerImgWidths),
                    right = BannerForm.activateDropzone(bannerType, 'right', validNumberImgs, validBannerImgWidths),
                    double ={
                        type: bannerType,
                        left: left,
                        right: right
                    };
                BannerForm.submit(double);
                break;
            case 'triple':
                var left = BannerForm.activateDropzone(bannerType, 'left', validNumberImgs, validBannerImgWidths),
                    middle = BannerForm.activateDropzone(bannerType, 'middle', validNumberImgs, validBannerImgWidths),
                    right = BannerForm.activateDropzone(bannerType, 'right', validNumberImgs, validBannerImgWidths),
                    triple = {
                        type: bannerType,
                        left: left,
                        middle: middle,
                        right: right
                    };
                BannerForm.submit(triple);
            default:
                break;
        }
    },

    dropZone: {},

    thumbNailEvents: {},

    /*
     * @bannerType: string for banner type (single, double, triple)
     * @side: string for side of banner (left, middle, right)
     * @maxImgQty: number for maxFiles option
     * @validImgWidths: array of valid img widths
     */
    activateDropzone: function (bannerType, side, maxImgQty, validImgWidths){
        var dropZoneContainer = $('#drop-' + side + '-' + bannerType),
            dropZoneDiv = dropZoneContainer.find('.dropzone'),
            dropZoneID = '#' + dropZoneDiv.attr('id'),
            dropZoneVarName = 'my' + side + bannerType + 'DropZone',
            validImgWidthString = validImgWidths.toString();

        dropZoneContainer.removeClass('hidden');

        /*
         *  THIS IF STATEMENT PREVENTS TRYING TO REACTIVATE ALREADY ACTIVE DROPZONES AND
         *  AVOID JS ERRORS.  DO NOT REMOVE THIS
         */
        if(!(dropZoneDiv.hasClass('dz-clickable'))) {
            /*
             * CREATE THE DROPZONE OBJECT THAT ACTIVATES THE DROPZONE(S)
             * ASSOCIATED WITH THE BANNER TYPE
             */
            BannerForm.dropZone[dropZoneVarName] = new Dropzone(dropZoneID, {
                acceptedFiles: 'image/jpeg, image/png',
                addRemoveLinks: true,
                autoProcessQueue: false,
                dictDefaultMessage: 'Please insert <b>' + maxImgQty + '</b> valid img/png images with the following valid pixel widths: <b>(' + validImgWidthString + ')</b>',
                maxFiles: maxImgQty,
                maxFilesize:.5,
                parallelUploads: 1,
                thumbnailWidth: 2000,
                thumbnailMethod: 'contain',
                url: "upload-adaptive-banner.php"
            });

            /*
             *  I WAS TRYING TO FIZ THE PROBLEM WITH THE HEIGHT VALIDATION BY TRIGGERING
             *  SOMETHING ON THE FINAL THUMBNAIL ADD, BUT STILL NOT WORKING....
             */
            BannerForm.dropZone[dropZoneVarName]['thumbnailEvents'] = 0;

            BannerForm.dropZone[dropZoneVarName].on("sending", function (file, xhr, formData) {
                var jobNumber = $('#job-number').val();
                formData.append("job-number", jobNumber);
            });

            BannerForm.dropZone[dropZoneVarName].on("thumbnail", function (file, event) {
                /*
                    THIS TIMEOUT COULD PROBABLY GO.  WAS HAVING DIFFICULTY GETTING THE ACTUAL HEIGHT AND WIDTH
                    AT THE CORRECT TIME IT SOMETIMES WORKS.
                 */
                BannerForm.dropZone[dropZoneVarName]['thumbnailEvents']++;
                if(BannerForm.dropZone[dropZoneVarName]['thumbnailEvents']==validImgWidths.length){
                    BannerForm.dropZone[dropZoneVarName]['thumbnailEvents']=0;
                }
                setTimeout(
                    Validate.form(bannerType, validImgWidths, BannerForm.formFields, BannerForm.textFields, file, this),
                3000);
            });
            BannerForm.dropZone[dropZoneVarName].on("complete", function (file) {
                BannerForm.dropZone[dropZoneVarName].processQueue();
            });



            $('button#remove-files').click(function(e){
                e.preventDefault();
                BannerForm.dropZone[dropZoneVarName].removeAllFiles();
                dropZoneContainer.find('.alert-danger').remove();
                Validate.form(bannerType, validImgWidths, BannerForm.formFields, BannerForm.textFields);
            });

            return BannerForm.dropZone[dropZoneVarName];
        }

        return false;
    },

    submit: function (banner) {
        var bannerType = banner['type'],
            submitButton = $('button#form-submit-' + bannerType);
        $('.form-submit').unbind('click');
        if(!submitButton.hasClass('armed')) {
            submitButton.click(function (e) {
                e.preventDefault();
                var uploads, uploadCount;
                switch (bannerType) {
                    case "single":
                        uploads = $('#img-dropzone-left-single .dz-preview');
                        uploadCount = uploads.length;

                        banner['single'].processQueue();
                        break;

                    case "double":
                        uploads = $('#img-dropzone-left-double .dz-preview, #img-dropzone-right-double .dz-preview');
                        uploadCount = uploads.length;

                        banner['left'].processQueue();
                        banner['right'].processQueue();
                        break;

                    case "triple":
                        uploads = $('#img-dropzone-left-triple .dz-preview, #img-dropzone-middle-triple .dz-preview, #img-dropzone-right-triple .dz-preview');
                        uploadCount = uploads.length;

                        banner['left'].processQueue();
                        banner['middle'].processQueue();
                        banner['right'].processQueue();
                        break;

                    default:
                        break;
                }

                uploads.each(function (i) {
                    if (i == uploadCount - 1) {
                        var formData = $('form').serialize();
                        $.post('create-adaptive-banner-html.php', formData)
                            .done(function (data) {
                                //alert(data);
                            })
                            .fail(function () {
                                alert("Banner HTML was not created.")
                            });
                    }
                });
            });
        }
        submitButton.addClass('armed');
    }
};