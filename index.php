<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link rel="stylesheet" href="jquery-ui-1.12.1.custom/jquery-ui.min.css">
<link rel="stylesheet" href="jquery-ui-1.12.1.custom/jquery-ui.theme.min.css">
<link type="text/css" rel="stylesheet" href="node_modules/dropzone/dist/dropzone.css" />
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

<style>
    button[disabled]{
        opacity: .6;
    }
    .input-group{
        margin-bottom:2em;
    }
    .dropzone .dz-preview .dz-image{
        width:100%;
    }
    .form-group, .checkbox{
        margin-right:1em;
        height:100px;

    }
    .checkbox label{
        font-weight: 600;
    }
    label{padding-top: 6px;}
    .alert{
        margin-top:.5em;
    }
    button{
        margin-bottom:3em!important;
    }
    .cta-url{
        width:100%;
    }
</style>


<form method="post" enctype="multipart/form-data">
    <div class="col-md-8">

        <div class="form-inline">
            <h1>Adaptive Banner</h1>
            <div class="form-group">
                <select id="banner-type" class="form-control" name="banner-type">
                    <option value="null"> - Select a Banner Type - </option>
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                    <option value="triple">Triple</option>
                </select>
            </div>
            <span id="generic-form-fields" class="hidden">
                <div class="checkbox">
                    <label class="checkbox-inline"> Clickable? <input id="clickable" type="checkbox" name="clickable" value="true"/></label>
                </div>

                <div class="form-group">
                    <label for="job-number">Job Number</label>
                    <input class="form-control" id="job-number" min="10000" type="number" name="job-number"/>
                </div>

                <div class="form-group">
                    <label for="release-date">Release Date</label>
                    <input class="datepicker form-control" id="release-date" type="text" name="release-date" placeholder="FORMAT: YYYYMMDD" />
                </div>


            </span>
        </div>
    </div>

    <div id="magic-word" class="col-md-4" style="display: none;">
        <img src="magic-word.gif"  />
    </div>

    <div class="input-group-lg col-xs-12">
        <div class="dz hidden" id="drop-left-single">

            <div class="panel panel-default">
                <div class="panel-heading">Single Banner File Upload</div>
                    <div id="img-dropzone-left-single" class="dropzone panel-body dropzone-single">
                </div>
            </div>
            <div class="row">
                <div class="cta-url-container cta-url-container-single form-group col-xs-12 hidden">
                    <label for="cta-url">SINGLE BANNER CTA URL</label>
                    <input class="form-control cta-url" type="url" name="cta-url-single" placeholder="Please enter a valid URL including the http:// or https://"/>
                </div>
            </div>
        </div>
        <div class="dz hidden" id="drop-left-double">
            <div class="panel panel-default">
                <div class="panel-heading">Left Banner File Upload</div>
                    <div id="img-dropzone-left-double" class="dropzone panel-body dropzone-double">
                </div>
            </div>
            <div class="row">
                <div class="cta-url-container cta-url-container-double form-group col-xs-12 hidden">
                    <label for="cta-url">LEFT BANNER CTA URL</label>
                    <input class="form-control cta-url" type="url" name="cta-url-double-left" placeholder="Please enter a valid URL including the http:// or https://"/>
                </div>
            </div>

        </div>
        <div class="dz hidden" id="drop-left-triple">
            <div class="panel panel-default">
                <div class="panel-heading">Left Banner File Upload</div>
                    <div id="img-dropzone-left-triple" class="dropzone panel-body dropzone-triple">
                </div>
            </div>
            <div class="row">
                <div class="cta-url-container form-group col-xs-12 hidden">
                    <label for="cta-url">LEFT BANNER CTA URL</label>
                    <input class="form-control cta-url" type="url" name="cta-url-triple-left" placeholder="Please enter a valid URL including the http:// or https://"/>
                </div>
            </div>
        </div>
        <div class="dz hidden" id="drop-middle-triple">
            <div class="panel panel-default">
                <div class="panel-heading">Middle Banner File Upload</div>
                    <div id="img-dropzone-middle-triple" class="dropzone panel-body dropzone-triple">
                </div>
            </div>
            <div class="row">
                <div class="cta-url-container cta-url-container-triple form-group col-xs-12 hidden">
                    <label for="cta-url">MIDDLE BANNER CTA URL</label>
                    <input class="form-control cta-url triple" type="url" name="cta-url-triple-middle" placeholder="Please enter a valid URL including the http:// or https://"/>
                </div>
            </div>
        </div>
        <div class="dz hidden" id="drop-right-double">
            <div class="panel panel-default">
                <div class="panel-heading">Right Banner File Upload</div>
                    <div id="img-dropzone-right-double" class="dropzone panel-body dropzone-double">
                </div>
            </div>
            <div class="row">
                <div class="cta-url-container cta-url-container-double form-group col-xs-12 hidden">
                    <label for="cta-url">RIGHT BANNER CTA URL</label>
                    <input class="form-control cta-url" type="url" name="cta-url-double-right" placeholder="Please enter a valid URL including the http:// or https://"/>
                </div>
            </div>
        </div>
        <div class="dz hidden" id="drop-right-triple">
            <div class="panel panel-default">
                <div class="panel-heading">Right Banner File Upload</div>
                    <div id="img-dropzone-right-triple" class="dropzone panel-body dropzone-triple">
                </div>
            </div>
            <div class="row">
                <div class="cta-url-container cta-url-container-triple form-group col-xs-12 hidden">
                    <label for="cta-url">RIGHT BANNER CTA URL</label>
                    <input class="form-control cta-url" type="url" name="cta-url-triple-right" placeholder="Please enter a valid URL including the http:// or https://"/>
                </div>
            </div>
        </div>
        <div class="input-group-lg">
            <input id="banner-height" type="hidden" name="banner-height"/>
            <button class="hidden btn btn-default" id="remove-files">Remove All Files</button>
            <button disabled id="form-submit-single" class="hidden form-submit btn btn-default">Submit</button>
            <button disabled id="form-submit-double" class="hidden form-submit btn btn-default">Submit</button>
            <button disabled id="form-submit-triple" class="hidden form-submit btn btn-default">Submit</button>
        </div>
    </div>
</form>

<script src="node_modules/dropzone/dist/dropzone.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/moment.js"></script>
<script src="js/banner-validator.js"></script>
<script src="js/banner-form.js"></script>
<script src="js/script.js"></script>