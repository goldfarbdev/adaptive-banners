/**
 * Created by Greg.Goldfarb on 7/1/17.
 */
var Validate = {
    currentBannerType: '',
    form: function (bannerType, validBannerImgWidths, formFields, textFields, file, myDropZone) {
        'use strict';
        var formSubmitBtn = $('#form-submit-' + bannerType),
            minNumberImgs,
            dropzones = $('.dropzone-'+ bannerType);
        Validate.currentBannerType = bannerType;
        Validate.currentDropZone = myDropZone;

        $('.alert-danger').remove();

        formFields.each(function(){
            var field = $(this),
                valid = field.is('#clickable') ? true : Validate.field(field, formSubmitBtn, Validate.currentBannerType);

            if(valid === false) {
                if (field.hasClass('datepicker')) {
                    field.after('<div class="alert alert-danger">You have entered an invalid date.</div>');
                } else if (field.is('input[type="url"]')) {
                    field.after('<div class="alert alert-danger">Please enter a valid URL.');
                } else {
                    field.after('<div class="alert alert-danger">Please enter a valid job number greater than ' + $(this).attr('min') + '.</div>');
                }
            }

        });

        minNumberImgs = validBannerImgWidths.length;

        $.each(dropzones, function() {
            var validDropZone;

            if(typeof Validate.currentDropZone !== 'undefined') {
                validDropZone = $(this).attr('id') !== Validate.currentDropZone.element.id ?
                    Validate.dropZone($(this), minNumberImgs, validBannerImgWidths)
                    : Validate.dropZone($(this), minNumberImgs, validBannerImgWidths, file);
            } else{
                validDropZone = Validate.dropZone($(this), minNumberImgs, validBannerImgWidths, file);
            }
            if (validDropZone.valid === false) {
                $(this).after('<div class="alert alert-danger" style="margin-bottom: 0;">'+ validDropZone.error +'</div>');
            }
        });

        if($('.alert-danger').length > 0){
            formSubmitBtn.attr('disabled', 'disabled');
            $('#magic-word').show();
        } else {
            textFields.each(function(){
                var value = $(this).val();
                if(!$.trim(value)){
                    formSubmitBtn.attr('disabled', 'disabled');
                    return;
                }
                $('#magic-word').hide();
                formSubmitBtn.removeAttr('disabled');
            });
        }

    },

    field: function(field, formSubmitBtn, bannerType){
        var fieldValue = field.val(),
            isThisValid;

        if(field.hasClass('datepicker')){
            isThisValid = Validate.date(fieldValue);
        } else {
            switch (field[0].type) {
                case "text":
                    isThisValid = Validate.textfield(fieldValue);
                    break;
                case "number":
                    isThisValid = Validate.number(parseInt(fieldValue.trim()), field.attr('min'));
                    break;
                case "checkbox":
                    isThisValid = true;
                case "url":
                    if(field.parent().hasClass('cta-url-container-' + bannerType)){
                        isThisValid = Validate.url(field, fieldValue);
                    } else {
                        isThisValid = true;
                    }
                    break;
                default:
                    break;
            }
        }

        if(isThisValid === false) {
            formSubmitBtn.attr('disabled');
        }

        return isThisValid;
    },

    date: function(dtValue) {
        return moment(dtValue, 'YYYYMMDD', true).isValid();
    },

    number: function(fieldValue, minLength) {
        if(fieldValue >= minLength && typeof(fieldValue) === 'number'){
            return !(!fieldValue);
        }

        return false;
    },
    url: function (field, value) {
        if(field.parent().hasClass('hidden')){
            return true;
        }

        var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");

        if (urlregex.test(value)) {
            return true;
        }

        return false;
    },
    textfield: function(fieldValue) {
        return !(!fieldValue);
    },
    currentDropZone: '',
    dropZone: function(dropZone,minNumImgs, validImgWidths, files, dropZoneObject) {
        var imagePreviewContainer = dropZone.find('.dz-preview').not('.dz-error'),
            dzValidation = {valid: true, error: ''},
            validImgNum = 0,
            takenValidImgWidths = [],
            imagePreviewContainerLength = imagePreviewContainer.length,
            validImgWidth, validImgHeight, imgWidth;

        if(typeof files === "object"){
            //At this point we have all the 'files' in the files object
            //Iterate through each to validate its width
            for(var i=0; i<files.length; i++){
                imgWidth = files[i].width;
                validImgWidth = Validate.imgWidth(imgWidth, validImgWidths);
                if(validImgWidth.valid !== true){
                    dzValidation = validImgWidth;
                    return dzValidation;
                }
            }

            //If we've gotten this far then check to see if there are any duplicate widths
            imagePreviewContainer.each(function () {
                var imagePreview = $(this).find('img'),
                    imageWidth = imagePreview[0].clientWidth;
                if (takenValidImgWidths.indexOf(imgWidth) === -1) {
                    takenValidImgWidths.push(imageWidth);
                    validImgNum++;
                } else {
                    imagePreviewContainerLength--;
                    dzValidation = {
                        valid: false,
                        error: "<p>You have more than 1 image with the width of " + imageWidth + ".</p>"
                    };
                    return false;
                }
            });
        } else if(imagePreviewContainerLength === 0) {
            dzValidation = {
                valid: false,
                error: ""
            };
        } else {
            imagePreviewContainer.each(function () {
                if (!$(this).hasClass('dz-error')) {
                    var container = $(this),
                        imagePreview = container.find('img'),
                        imageName = container.find('.dz-filename > span').text(),
                        imgWidth = imagePreview[0].naturalWidth,
                        validImgWidth = Validate.imgWidth(imgWidth, validImgWidths, imageName),
                        imgName;

                    if (validImgWidth.valid === true) {
                        if (takenValidImgWidths.indexOf(imgWidth) === -1) {
                            takenValidImgWidths.push(imgWidth);
                            validImgNum++;
                        } else {
                            imagePreviewContainerLength--;
                            dzValidation = {
                                valid: false,
                                error: "<p>You have more than 1 image with the width of " + imgWidth + '.</p>'
                            };
                            return false;
                        }
                    } else {
                        imagePreviewContainerLength--;
                        imgName = $(this).find('.dz-filename span').text();
                        dzValidation = {
                            valid: false,
                            error: "<p>The image you uploaded named " + imgName + " contains an invalid width of " + imgWidth + ".</p>" +
                                "<p>You must upload images with the following widths: " + validImgWidths + ".</p>"
                        };
                        return false;
                    }
                }
            });
        }

        if( imagePreviewContainerLength < minNumImgs) {
            dzValidation.valid = false;
            dzValidation.error += "<p>Please add <b>" + (minNumImgs - imagePreviewContainerLength) + "</b> valid banner images to this drop zone.</p>";
        }
        else{
            // Validate.imgHeight(dropZone, file);
            validImgHeight = Validate.imgHeight(dropZone, files);
            if(validImgHeight.valid === false){
                dzValidation.valid = false;
                dzValidation.error += validImgHeight.error;
            }
        }

        return dzValidation;
    },
    getValidBannerImgWidths: function(bannerType, validImgWidths) {
        return validImgWidths[bannerType];
    },
    imgWidth: function(imgWidth, validImgWidths, imgName) {
        if (validImgWidths.indexOf(imgWidth) === -1) {
            return {
                valid: false,
                error: "<p>The image you uploaded named " + imgName + " contains an invalid width of " + imgWidth + ".</p>" +
                "<p>You must upload images with the following widths: " + validImgWidths + ".</p>"
            };
        }
        return {valid:true};
    },
    imgHeight: function(dropZone, files) {
        'use strict';
        var bannerImages =  dropZone.find('img'),
            imgObj = {},
            bannerHeight = 0,
            imageHeightsValid = true;

            $.each(files, function (index, currentImage) {
                imgObj['image'+index] = {};
                imgObj['image'+index].name = currentImage.alt;
                imgObj['image'+index].height = currentImage.height;
                bannerHeight=currentImage.height;
                if(index > 0 && (imgObj['image'+index].height !== imgObj['image'+(index-1)].height) && (imageHeightsValid === true)){
                    imageHeightsValid = false;
                }
            });
        bannerImages.each(function (index, currentImage) {
            imgObj['image'+index] = {};
            imgObj['image'+index].name = currentImage.alt;
            imgObj['image'+index].height = currentImage.height;
        });
        if(imageHeightsValid){
            $('#banner-height').val(bannerHeight);
        }
        return {valid: imageHeightsValid, error: "<p>The following images do not contain equal height</p>: " + JSON.stringify(imgObj), bannerHeight: bannerHeight};
    }
};