<?php
namespace Mayank\TodoTask\Controllers;

use Illuminate\Http\Request;
use Validator;
use Mayank\TodoTask\Models\Category;
use Mayank\TodoTask\Models\Task;

class ApiController extends Controller
{
    private $limit = 10;
    
    public function getCategories(Request $request) {
        
        $category_data = Category::orderBy('created_at', 'DESC')->paginate($this->limit)->toArray();
        $categories_id = array_column($category_data['data'], 'id');

        $task_data = Task::whereIn('category_id', $categories_id)->get()->toArray();
        $tasks = [];

        if(!empty($task_data)) {
            foreach($task_data as $task) {
                if(!array_key_exists($task['category_id'], $tasks)) {
                    $tasks[$task['category_id']] = [];
                }
                $tasks[$task['category_id']][] = $task;
            }
        }
        $response = $category_data;
        unset($response['data']);
        foreach($category_data['data'] as $val) {
            $temp = $val;
            $temp['task_list'] = array_key_exists($val['id'], $tasks) ? $tasks[$val['id']]: [];
            $response['data'][] = $temp;
        }

        return response()->json($response);
    }

    public function addCategories(Request $request) {
        $rules = array('name' => 'required|max:30|unique:categories');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $category_model = new Category();
        $category_model->name = $request->name;
        $category_model->save();

        return response()->json(array('message'=> 'Category added successfully', 'category' => $category_model));

    }

    public function updateCategories(Request $request, $id) {

        $rules = array('name' => 'required|max:30|unique:categories');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);   
        }

        $category_model = Category::find($id);
           
        if($category_model == null) {
            return response()->json(array('message'=> 'Category id not found'), 400);    
        }
        
        $category_model->name = $request->name;
        $category_model->save();
        
        return response()->json(array('message'=> 'Category updated successfully', 'category' => $category_model));
    }

    public function deleteCategories($id) {
        $category_model = Category::find($id);
           
        if($category_model == null) {
            return response()->json(array('message'=> 'Category id not found'), 400);    
        }
        $category_model->delete();
        return response()->json(array('message'=> 'Deleted category and their task list'), 200);
    }

    public function getTaskByCategory(Request $request, $category_id) {
        
        if (!is_numeric($category_id)) {    
            return response()->json(array('message'=> 'Category ID must be integer value.'), 400);   
        }

        $response = Task::where('category_id',$category_id)->paginate($this->limit) ;

        if(count($response)) {
            return response()->json($response);
        } else {
            return response()->json(array('message' => 'No task found for given category'), 404);
        }
    }

    public function addTask(Request $request, $category_id) {
        $rules = array('title' => 'required|max:200');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $category_model = Category::find($category_id);
           
        if($category_model == null) {
            return response()->json(array('message'=> 'Category id not found'), 400);    
        }

        $task_model = new Task();
        $task_model->title = $request->title;
        $task_model->category_id = $category_id;
        $task_model->is_completed = 0;
        $task_model->save();

        return response()->json(array('message'=> 'Task added successfully', 'task' => $task_model));
    }

    public function updateTask(Request $request, $categoryId, $id) {

        $rules = array(
            'title' => 'max:200', 
            'isCompleted' => 'boolean'
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        if (!is_numeric($categoryId)){
            return response()->json(array('message'=> 'Category not found.'), 400);   
        } else if (!is_numeric($id)) {    
            return response()->json(array('message'=> 'Task not found.'), 400);   
        }

        $condition = array(
            'category_id' => $categoryId, 
            'id'=> $id
        );
        $task_model = Task::where($condition)->first();

        if($task_model === null) {
            return response()->json(array('message' => 'This task does not belongs to given category'), 400);
        }

        if(isset($request->title)) {
            $task_model->title = $request->title;
        }

        if(isset($request->isCompleted) ){
            $task_model->is_completed = $request->isCompleted;
        }

        $task_model->save();

        return response()->json(array('message'=> 'Task updated successfully', 'task' => $task_model));
    }

    public function deleteTask($categoryId, $id) {
        $category_model = Category::find($categoryId);

        if ($category_model == null) {
            return response()->json(array('message'=> 'Category id not found'), 400);    
        }

        $condition = array(
            'category_id' => $categoryId, 
            'id' => $id
        );
        $task_model = Task::where($condition)->first();
           
        if($task_model == null) {
            return response()->json(array('message'=> 'Task does not belongs to given category'), 400);    
        }
        $task_model->delete();
        return response()->json(array('message'=> 'Task has been deleted'), 200);
    }
}