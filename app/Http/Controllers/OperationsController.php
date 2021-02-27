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
        $operation->save();

        $operation = DB::table('operations')
            ->orderBy('id', 'desc')
            ->where('userId', $operation->userId)
            ->first();

        return response()->json([
            'operation' => $operation
        ], 201);
    }
}
