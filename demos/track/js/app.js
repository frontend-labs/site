$(document).on('ready', function() {
    var gtrack = function(){
        dealAnalitics(arguments);
    };
    var dealAnalitics = function(argsParam){
        var prefix = ["\'send\'"," \'event\'"];
        var track = dealArgs(prefix, argsParam);
        var callBack = checkCallback(track);
        track = removeBooleans(track);
        track = removeEmptys(track);
        track = removeFunctions(track);
        //track = transformParams(track);
        if( typeof ga !== "undefined" ){
            console.log("ga("+track+")");
            //ga.apply(this, track);
            callBack && callBack.call(this, gtrack);
        }
    };
    var dealArgs = function(prefix, args){
        var result = prefix;
        _eachArray(args, function(i, e){
          result.push(e);
        });
        return result;
    };
    var transformEmptys2Undefined = function(collection){
        var result = [];
        _eachArray(collection, function(i, e){
            if($.trim(e) == ""){
              e = undefined;
            }
            result.push(e);
        });
        return result;
    };
    var removeBooleans = function(collection){
        _eachArray(collection, function(i, e){
            if(typeof e === "boolean"){
              collection.splice(i);
            }
        });
        return collection;
    };
    var removeEmptys = function(collection){
        _eachArray(collection, function(i, e){
            if($.trim(e) == ""){
              collection.splice(i);
            }
        });
        return collection;
    };
    var removeFunctions = function(collection){
        _eachArray(collection, function(i, e){
            if(typeof e === "function"){
              collection.splice(i);
            }
        });
        return collection;
    };
    var checkCallback = function(collection){
        var callback = false;
         _eachArray(collection, function(i, e){
            if(typeof e === "function"){
                callback = e;
            }
        });
        return callback;
    };
    var _eachArray = function(collection, everyItem){
        for(var index = 0; index < collection.length; index++){
            everyItem.call(this, index, collection[index]);
        }
    };
    var facebook = $('.social_links .fb'),
        twitter = $('.social_links .twitter'),
        google = $('.social_links .gplus');
    facebook.on('click', function(e) {
        gtrack(" \'Síguenos\'", " \'Facebook\'", " 0");
        e.preventDefault();
    });
    twitter.on('click', function(e) {
        gtrack(" \'Síguenos\'", " \'Twitter\'", " 0");
        e.preventDefault();
    });
    google.on('click', function(e) {
        gtrack(" \'Síguenos\'", " \'G+\'", " 0");
        e.preventDefault();
    });
});