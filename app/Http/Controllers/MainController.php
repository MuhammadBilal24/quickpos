<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;

class MainController extends Controller
{
    public function dashboardpage()
    {
        return view('dashboard');
    }
    // Account
    public function accountPage(request $request)
    {
        $data['accountData'] = DB::table('account')
            ->select('account.*', 'actype.actype as actype')
            ->join('actype', 'account.actype', '=', 'actype.id')
            ->get();
        $data['actypeData'] = DB::table('actype')->get();
        return view('account',$data);
    }
    public function accountInsert(request $request)
    {
        $date=$request->input('date');
        $acname=$request->input('acname');
        $actype=$request->input('actype');
        $cnic=$request->input('cnic');
        $address=$request->input('address');
        $city=$request->input('city');
        $phone=$request->input('phone');
        $acode=$request->input('acode');
        $status=$request->input('status');
        $data = array(
            'date'=>$request->date,
            'acname'=>$request->acname,
            'actype'=>$request->actype,
            'cnic'=>$request->cnic,
            'address'=>$request->address,
            'city'=>$request->city,
            'phone'=>$request->phone,
            'acode'=>$request->acode,
            'status'=>1,
        );
        DB::table('account')->insert($data);
        return response()->json(
            [
                'status'=>200,
                'messages'=>'Account Saved',
            ]
        );
    }
    // Account End

    // Account Details
    public function accountDetailsPage(request $request)
    {
        $data['accountDetails'] = DB::table('account')
        ->select('account.*', 'actype.actype as actype')
        ->join('actype', 'account.actype', '=', 'actype.id')
        ->where('account.id', $request->id)
        ->get();
        // var_dump($data);
        $data['cityData'] = DB::table('city')->get();
        return view('acdetails', $data);
    }
    public function accountDetailsUpdate(request $request , $id)
    {
        DB:: table('account')->where(['id'=>$id])->update([
            'id'=>$id,
            // 'date'=>$request->date,
            // 'acname'=>$request->acname,
            // 'actype'=>$request->actype,
            'cnic'=>$request->cnic,
            'address'=>$request->address,
            'city'=>$request->city,
            'phone'=>$request->phone,
            'acode'=>$request->acode,
            // 'status'=>$request->status,
        ]);
        return redirect()->back()->with('success', 'Account Updated');
    }
    public function accountDeactive(request $request)
    {
        DB::table('account')->where(['id'=>$request->id])->update([
            'id'=>$request->id,
            'status'=>0,
        ]);
        return response()->json(['status'=>200]);
    }
    public function accountActive(request $request)
    {
        DB::table('account')->where(['id'=>$request->id])->update([
            'id'=>$request->id,
            'status'=>1,
        ]);
        return response()->json(['status'=>200]);
    }
    // Account Details End

    // Account Type
    public function accountTypePage()
    {
        $data['actypeData'] = DB::table('actype')->get();
        return view('actype', $data);
    }
    public function accountTypeInsert(request $request)
    {
        $actype = $request->input('actype');
        $data = array(
            'actype'=>$request->actype,
        );
        DB::table('actype')->insert($data);
        return response()->json();
    }
    // Account Type End

    // City
    public function cityPage()
    {
        $data['cityData']= DB::table('city')->get();
        return view('city' , $data);
    }
    public function cityInsert(request $request)
    {
        $city = $request->input('city');
        $data = array(
            'city' => $request->city,
        );
        DB::table('city')->insert($data);
        return response()->json([
            'status'=>200,
            'messages'=>'New City Insert',
        ]);
    }
    public function cityDelete(request $request)
    {
        DB::table('city')->where(['id'=>$request->id])->delete();
        return response()->json([
            'status'=>200,
            'messages'=>'City Deleted',
        ]);
    }
    // City End

    // Category
    public function categoryPage()
    {
        $data['categoryData'] = DB::table('category')->get();
        return view('category', $data);
    }
    public function categoryInsert(request $request)
    {
        $name = $request->input('name');
        $data= array(
            'name'=>$request->name,
        );
        DB::table('category')->insert($data);
        return response()->json([
            'status'=>200,
            'messages'=>"Category Added",
        ]);
    }
    public function categoryDeleted(request $request)
    {
        DB::table('category')->where(['id'=>$request->id])->update([
            'id'=>$request->id,
            'deleted_category' => 1,
        ]);
        return response()->json([
            'status'=>200,
            'messages'=>"Category Deleted",
        ]);
    }
    public function categoryRestore(request $request)
    {
        $data = DB::table('category')->where(['id'=>$request->id])->update([
            'id'=>$request->id,
            'deleted_category'=>0,
        ]);
        return back();
    }
    // Category End

    // Profile
    Public function Productpage()
    {
        $data['categoryData']= DB::table('category')->get();
        $data['productData']= DB::table('products')
        ->select('products.*', 'category.name as category')
        ->join('category', 'products.category', '=', 'category.id')
        ->get();
        // var_dump($data1);
        return view('products', $data);
    }
    public function productInsert(request $request)
    {
        $pcode=$request->input('pcode');
        $barcode=$request->input('barcode');
        $pname=$request->input('pname');
        $category=$request->input('category');
        $cprice=$request->input('cprice');
        $rprice=$request->input('rprice');
        $wprice=$request->input('wprice');
        $discount=$request->input('pdiscount');
        $data=array(
            'pcode'=>$request->pcode,
            'barcode'=>$request->barcode,
            'pname'=>$request->pname,
            'category'=>$request->category,
            'cprice'=>$request->cprice,
            'rprice'=>$request->rprice,
            'wprice'=>$request->wprice,
            'discount'=>$request->discount,
        );
        DB::table('products')->insert($data);
        return response()->json(['status'=>200]);
    }
    public function productEdit(request $request)
    {
        $data=DB::table('products')->where(['id'=>$request->id])->first();
        // $data=DB::table('products')
        // ->select('products.*', 'category.name as category')
        // ->join('category', 'products.category', '=', 'category.id')
        // ->where(['products.id'=>$request->id])
        // ->first();
        return response()->json($data);
    }
    
    // User 
    public function usersPage()
    {
        $activeUser = ['LogginUser' => DB::table('users')->where('id', session('loggedInUser'))->first()];
        $data['usersData'] = DB::table('users')->get();
        return view('users', $data, $activeUser);
    }
    public function userDetailsPage(request $request)
    {
        $activeUser = ['LogginUser' => DB::table('users')->where('id', session('loggedInUser'))->first()];
        $data['userDetailsData'] = DB::table('users')->where(['id' => $request->id])->first();
        // $data = ['userInfo' => DB::table('users')->where('id', session('loggedInUser'))->first()];
        // var_dump ($data);
        return view('user_details', $data , $activeUser);
    }
    public function userDelete(request $request)
    {
        // $loggin = ['userInfo' => DB::table('users')->where('id', session('loggedInUser'))->first()];
        $data = User::find($request->id);
        if($data)
        {
            $data->delete();
            return response()->json([
                'status'=> 200,
                'messages'=>"User Deleted From Master-Board"
            ]);
        }
        else
        {
            return response()->json([
                'status'=> 400,
                'messages'=>"User Not Deleted",
            ]);
            return back();
        }
    }

    // Expense
    public function expensePage()
    {
        $data['accountData'] = DB::table('account')
        ->select('account.*', 'actype.actype as actype')
        ->join('actype', 'account.actype', '=', 'actype.id')
        ->get();
        $data['expenseData']=DB::table('expenses')
        ->select('expenses.*', 'account.acname as account','actype.actype as actype')
        ->join('account', 'expenses.account', '=', 'account.id')
        ->join('actype', 'account.actype', '=', 'actype.id')
        ->get();
        // var_dump($data);
        // $data['expenseData']= DB::table('expenses')->get();
        $sum_amount_expense['total_Expense'] = DB::select('SELECT SUM(amount) as total_sum FROM expenses');
        return view('expense', $data , $sum_amount_expense);
    }
    public function expenseStore(request $request)
    {
        $date= $request->input('date');
        $account= $request->input('account');
        $amount= $request->input('amount');
        $description= $request->input('description');
        $data=array(
            'date' => $request->date,
            'account' => $request->account,
            'amount' => $request->amount,
            'description' => $request->description,
        );
        DB::table('expenses')->insert($data);
        // return redirect('expense');
        return response()->json([
            'status' => 200,
            'messages' =>"Expense Added",
        ]); 
    }
    public function deleteExpenses(request $request)
    {
        // This method update expense table for delete = 1 s 
        $data = DB::table('expenses')->where(['id'=>$request->id])->update([
            'id'=>$request->id,
            // 'amount' => $amount,
            // 'description'=>$description,
            'deleted_expenses'=>1,
        ]);
        return back();
    }
    public function restoreExpenses(request $request)
    {
        $data = DB::table('expenses')->where(['id'=>$request->id])->update([
            'id'=>$request->id,
            // 'amount' => $amount,
            // 'description'=>$description,
            'deleted_expenses'=>0,
        ]);
        return back();
    }

    // Customization
    public function customizePage()
    {
        $data['customizeData']= DB::table('customize')->get();
        return view('customize',$data);
    }
    public function customizeInsert(request $request)
    {
        $title = $request->input('title');
        $value = $request->input('value');
        $data= array(
            'title' => $request->title,
            'value' => $request->value,
        );  
        DB::table('customize')->insert($data);
        return response()->json([
            'status'=> 200,
            'messages' => "Added",
        ]);
    }
    public function customizeEdit($id)
    {
        $data = DB::table('customize')->where(['id' => $id])->first();
        return response()->json($data);  
    }
    public function customizeUpdate(request $request)
    {
        // var_dump($request);
       $data = DB::table('customize')->where(['id'=>$request->id])->update([
                'id'=> $request->id,
                'title' => $request->title,
                'value' => $request->value,
            ]);
            return back();
    }
    
    // Trash {Deleted Data}
    public function trashPage()
    {
        $data['deletedCategory'] = DB::table('category')->where(['deleted_category' => 1])->get();
        $data['deletedExpense']=DB::table('expenses')
        ->select('expenses.*', 'account.acname as account','actype.actype as actype')
        ->join('account', 'expenses.account', '=', 'account.id')
        ->join('actype', 'account.actype', '=', 'actype.id')
        ->where(['deleted_expenses' => 1])
        ->get();
        // $data['deletedExpense'] = DB::table('expenses')->where(['deleted_expenses' => 1])->get(); 
        // var_dump($data);
        return view('trash',$data);
    }
    public function permenantTrashDeleteExpense(request $request)
    {
        $data = DB::table('expenses')->where(['id'=>$request->id])->delete();
        return back();
    }
    public function permenantTrashDeleteCategory(request $request)
    {
        DB::table('category')->where(['id'=>$request->id])->delete();
        return back();
    }
}