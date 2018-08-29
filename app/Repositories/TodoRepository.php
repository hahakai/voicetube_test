<?PHP
namespace App\Repositories;

//use Doctrine\Common\Collections\Collection;
use \App\Models\Todo;
use Illuminate\Support\Facades\DB;
class TodoRepository
{
    protected $todo;

    public function __construct(todo $todo){
        $this->todo = $todo;
    }
    public function index()
    {
        return Todo::get();
    }

    public function find($id){
        return Todo::find($id);
    }

    public function create(array $data)
    {
        return Todo::create($data);
    }
    public function done($request){
        $id=$request->input('id');
        $todo=$this->todo->find($id);
        $todo->done_at=date("Y-m-d H:i:s");
        return $todo->save();
    }
    public function destroy($id){
        $todo=$this->todo->find($id);
        $todo->deleted_at=date("Y-m-d H:i:s");
        return $todo->save();
    }
    public function delete_all(){
        return DB::table('todos')->update(['deleted_at' => date("Y-m-d H:i:s")]);;
    }
    public function update($request,$id){
        $todo=$this->todo->find($id);
        $todo->title=$request['title'];
        $todo->content=$request['content'];
        return $todo->save();
    }
}