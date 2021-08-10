<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationsController extends Controller
{
    public function getOperations(Request $request): JsonResponse
    {
        $operations = DB::table('operations')
            ->orderBy('id', 'desc')
            ->where('userId', $request->header('user-id'))
            ->get();

        return response()->json([
            'operations' => $operations
        ], 201);
    }

    public function addOperation(Request $request): JsonResponse
    {
        $operation = new Operation();

        $operation->value = $request->value;
        $operation->category = $request->category;
        $operation->type = $request->type;
        $operation->userId = $request->userId;
        $operation->created_at = $request->created_at;
        $operation->updated_at = $request->updated_at;
        $operation->save();

        $operation = DB::table('operations')
            ->orderBy('id', 'desc')
            ->where('userId', $operation->userId)
            ->first();

        return response()->json([
            'operation' => $operation
        ], 201);
    }

    public function editOperation(Request $request)
    {
        $id = $request->id;
        $value = $request->value;
        $category = $request->category;
        $updated_at = $request->updated_at;

        DB::table('operations')
            ->where('id', $id)
            ->update(['value' => $value, 'category' => $category, 'updated_at' => $updated_at]);

        $operation = DB::table('operations')
            ->where('id', $id)
            ->first();

        return response()->json([
            'operation' => $operation
        ], 200);
    }

    public function deleteOperation(Request $request)
    {
        $id = $request->id;

        DB::table('operations')->where('id', $id)->delete();

        return response()->json($id, 200);
    }
}
