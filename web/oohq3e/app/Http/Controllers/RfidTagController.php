<?php
namespace App\Http\Controllers;

use App\Models\RfidTag;
use App\Models\Esp;
use App\Models\RfidUseData;
use Carbon\Carbon;
use Egulias\EmailValidator\Result\SpoofEmail;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class RfidTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $readers = Esp::where('type','RFID Reader')->get();
        $tags = RfidTag::all();

        return view('RFIDsettings',[
            'readers' => $readers,
            'tags' => $tags
           ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Esp $reader)
    {
        if ($reader !== null){
            return view('rfid.create',[
                'reader' => $reader
            ]);
        }else{
            $error = 'You need to add an RFID reader first!';
            return redirect()->back()->with(['error'=> $error]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Esp $reader)
    {
        $request->validate([
                'name' => 'required|max:50',
                'uid'=> 'required|max:20',
                'reader' => "required|integer"
            ]
        );
        $existing = DB::table("rfid_tag")
                ->where("esp_id","=", $reader->id)
                ->where("uid","=",$request->get("uid"))
                ->first();
        if ($existing!==null){
            return back()
                ->with('error','This reader already has this uid!');
        }else{
        $tag = new RfidTag();
        $tag -> name = $request->get("name");
        $tag -> uid = $request->get("uid");
        $tag -> esp_id = $reader->id;
        //dd($tag);
        $tag->save();
        $message = 'Succesfully added a new tag uid('.$tag->uid.') to reader: '.$reader->name;
         return redirect('/settings/RFID')->with(['message'=> $message]);}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RfidTag  $rfidTag
     * @return \Illuminate\Http\Response
     */
    public function show(RfidTag $rfidTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RfidTag  $rfidTag
     * @return \Illuminate\Http\Response
     */
    public function edit(Esp $reader, RfidTag $tag)
    {
        $readers = Esp::where('type','RFID Reader')->get();
        if ($reader !== null && $tag !== null){
            return view('rfid.modify',[
                'reader' => $reader,
                'tag'=> $tag,
                'readers' => $readers
            ]);
        }else{
            $error = 'This RFID tag does not exist!';
            return redirect()->back()->with(['error'=> $error]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RfidTag  $rfidTag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Esp $reader,RfidTag $tag,)
    {
        $request->validate([
                'name' => 'required|max:50',
                'uid'=> 'required|max:20',
                'reader' => "required|integer"
            ]
        );
        $existing = DB::table("rfid_tag")
            ->where("esp_id","=", $reader)
            ->where("uid","=",$request->get('uid'))
            ->first();

        if ($existing !== null){
            return back()
                ->with('error','This reader already has this uid!');
        }else{
            $ModifyTag = $tag;
            $ModifyTag -> name = $request->get("name");
            $ModifyTag -> uid = $request->get("uid");
            $ModifyTag -> esp_id = $request->get("reader");
            $ModifyTag -> updated_at = Carbon::now();
            $ModifyTag->save();
            $oldData = RfidUseData::where('tag_id',$tag->id)->get();
            if ($reader->id !== $request->get('reader') && $oldData !== null){
                DB::delete("DELETE FROM rfid_use_data WHERE tag_id = ".$tag->id.";");
            }
            $message = 'Succesfully modified tag with uid('. $ModifyTag ->uid.")";
            return redirect('/settings/RFID')->with(['message'=> $message]);}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RfidTag  $rfidTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(RfidTag $tag){
        $oldData = RfidUseData::where("tag_id",$tag->id)->get();
        $reader = Esp::where('id',$tag->esp_id)->first();

        $tag->delete();

        if ($oldData !== null){
            DB::delete("DELETE FROM rfid_use_data WHERE tag_id = ".$tag->id.";");
        }
        $message = 'Succesfully deleted tag with uid('. $tag ->uid. "), from: ".$reader->name;
        return redirect('/settings/RFID')->with(['message'=> $message]);
    }
}
