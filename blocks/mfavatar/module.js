/**
 * @Version: 0.0.1
 * @Author: Luuk Verhoeven
 * Copyright  Luuk Verhoeven
 **/
M.block_mfavatar = {
    log  : function (val)
    {
        try
        {
            console.log(val);
        } catch (e)
        {

        }
    },
    init : function (Y, applicationpath, expresspath, flashvars)
    {
        swfobject.embedSWF(
            applicationpath,
            "snapshot", "100%", "100%", "11.1.0",
            expresspath,
            flashvars, {
                menu             : "false",
                scale            : "noScale",
                allowFullscreen  : "true",
                allowScriptAccess: "always",
                wmode            : "transparent",
                bgcolor          : "#fff"
            },
            {
                id: "snapshot"
            },
            function (e)
            {
                //we are loaded?
                // this.log(e);
            });
    },
    saved: function ()
    {
        this.log('Saved!!!');
        var profilePicture = Y.one('img.profilepic');
        if (profilePicture)
        {
            var src = profilePicture.getAttribute('src');
            profilePicture.setAttribute('src', '');
            setTimeout(function ()
            {
                var now = new Date().getTime() / 1000;
                profilePicture.setAttribute('src', src + '&c=' + now);
            }, 500);

        }
    },
    error: function (err)
    {
        this.log('Error!');
        this.log(err);
    }
}
