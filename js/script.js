/**
 * Created by Greg.Goldfarb on 6/20/17.
 */
/*global jQuery, moment*/

(function($){
    var validImgWidths = {
            single: [1008, 1260, 1512, 1764],
            double: [500, 624, 752, 878],
            triple: [420, 630]
        };

        new BannerForm.initiate($('form'), validImgWidths);

}(jQuery));