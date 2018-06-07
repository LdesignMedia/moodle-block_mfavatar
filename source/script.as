import flash.display.SimpleButton;
import flash.display.DisplayObject;
import flash.media.Camera;
import flash.events.Event;
import flash.events.MouseEvent;
import flash.display.BitmapData;
import flash.utils.ByteArray;
import com.adobe.images.JPGEncoder;
import flash.display.MovieClip;
import flash.display.Bitmap;
import org.phprpc.util.Base64;
import flash.net.URLLoader;
import flash.net.URLRequest;
import flash.net.URLVariables;
import flash.events.IOErrorEvent;
import flash.events.HTTPStatusEvent;

btn1.enable(false);
combo1.prompt = " ";
mcVideo.theVideo.smoothing = true;

var cams:Array = Camera.names;
var cam:Camera;
var hasCam:Boolean;
var snapshotCreated:Boolean;
var i:int;
var w:int = 640;
var h:int = 480;
var encodedBytes:ByteArray;
var encoder:JPGEncoder = new JPGEncoder(80);
var ul:URLLoader;
var mcSnapshot:MovieClip;
var sessionid:String = "";
var identity:String;
var uploadPath:String = "http://moodle281.moodlefreak.com/blocks/mfavatar/upload.php";

var text_select_device:String = "Please select your camera device and resolution here:";
var text_make_snapshot:String = "Save snapshot";
var text_feed_field:String = "Your camera feed";
var text_result_field:String = "Your result";
var failed_saving:String = "Error saving your snapshot!!";
var success_saving:String = "Snapshot saved!!!";

if (this.loaderInfo.parameters.sessionid)
{
    sessionid = this.loaderInfo.parameters.sessionid;
}
if (this.loaderInfo.parameters.identity)
{
    identity = this.loaderInfo.parameters.identity;
}
if (this.loaderInfo.parameters.uploadPath)
{
    uploadPath = this.loaderInfo.parameters.uploadPath;
}
//setting custom strings
if (this.loaderInfo.parameters.text_select_device)
{
    text_select_device = this.loaderInfo.parameters.text_select_device;
}
if (this.loaderInfo.parameters.text_make_snapshot)
{
    text_make_snapshot = this.loaderInfo.parameters.text_make_snapshot;
}
if (this.loaderInfo.parameters.text_feed_field)
{
    text_feed_field = this.loaderInfo.parameters.text_feed_field;
}
if (this.loaderInfo.parameters.text_result_field)
{
    text_result_field = this.loaderInfo.parameters.text_result_field;
}
if (this.loaderInfo.parameters.failed_saving)
{
    failed_saving = this.loaderInfo.parameters.failed_saving;
}

if (this.loaderInfo.parameters.success_saving)
{
    success_saving = this.loaderInfo.parameters.success_saving;
}

//init text
select_device.text = text_select_device;
feed_field.text = text_feed_field;
result_field.text = text_result_field;

button_text.text = text_make_snapshot;
button_text.selectable = false;
button_text.mouseEnabled = false;

for (i = 0; i < cams.length; i++)
{
    var o:Object = new Object();
    o.label = cams[i];
    combo1.addItem(o);
}

combo1.addEventListener(Event.CHANGE, _combo1Change);
btn1.addEventListener(MouseEvent.CLICK, _btn1Click);

function _combo1Change(e:Event):void
{
    if (combo1.selectedIndex > -1)
    {
        cam = Camera.getCamera(String(combo1.selectedIndex));
        mcVideo.theVideo.attachCamera(cam);
        hasCam = true;
        snapshotCreated = false;
        check();
    }
}

function check():void
{
    if (hasCam)
    {
        btn1.enable();
        cam.setMode(w, h, 25);
        mcVideo.theVideo.width = w;
        mcVideo.theVideo.height = h;
        mcVideo.width = 320;
        mcVideo.height = 240;
    }
    else
    {
        btn1.enable(false);
    }

    //upload the snapshot
    if (snapshotCreated)
    {
        _upload();
    }
}

function _btn1Click(e:MouseEvent):void
{
    btn1.enable(false);
    var bmp:BitmapData = new BitmapData(w, h);
    bmp.draw(mcVideo);
    encodedBytes = encoder.encode(bmp);
    if (encodedBytes.length > 0)
    {
        mcSnapshot.removeChildren();
        var bitmp:Bitmap = new Bitmap(bmp, "auto", true);
        mcSnapshot.addChild(bitmp);
        mcSnapshot.width = 320;
        mcSnapshot.height = 240;
        snapshotCreated = true;
        check();
    }
    btn1.enable(true);
}

function _upload():void
{
    btn1.enable(false);
    var b64result:String = Base64.encode(encodedBytes);
    ul = new URLLoader();

    var v:URLVariables = new URLVariables();
    v.sesskey = sessionid;
    v.file = b64result;

    var req:URLRequest = new URLRequest(uploadPath);
    req.method = URLRequestMethod.POST;
    req.requestHeaders.push(new URLRequestHeader('Cache-Control', 'no-cache'));
    req.data = v;

    ul.dataFormat = URLLoaderDataFormat.TEXT;
    ul.addEventListener(Event.COMPLETE, _snapshotSaved);
    ul.addEventListener(IOErrorEvent.IO_ERROR, _snapshotError);
    ul.addEventListener(HTTPStatusEvent.HTTP_STATUS, _snapshotStatus);
    ul.load(req);

}

function _snapshotSaved(e:Event):void
{
    var data:Object =  JSON.parse(ul.data);

    if(data.status == true)
    {
        theText.text = success_saving;
        ExternalInterface.call("M.block_mfavatar.saved");
        btn1.enable();
    }
    else
    {
        var error:String = failed_saving;
        for (var s:String in data) {

            if(s == "error")
            {
                error = data[s];
                break;
            }
            else if(s == "errors")
            {
                error = data[s][0];
                break;
            }
        }

        theText.text = error;
        ExternalInterface.call("M.block_mfavatar.error" , ul.data);
    }
}

function _snapshotError(e:IOErrorEvent):void
{
    ExternalInterface.call("M.block_mfavatar.error" , e.errorID);
}

function _snapshotStatus(e:HTTPStatusEvent):void
{
    trace(e.status);
    btn1.enable();
}