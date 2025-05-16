<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmployeeRequest;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $employeeService
    ) {}

    public function show(string $taskId, string $employeeId): JsonResponse
    {
        try {
            $employee = Employee::where('id', $employeeId)
                ->whereHas('tasks', fn($query) => $query->where('task_id', $taskId))
                ->firstOrFail();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data pegawai ditemukan',
                'code'    => 200,
                'data'    => $employee,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data pegawai tidak ditemukan',
                'code'    => 404,
            ], 404);
        }
    }

    public function update(UpdateEmployeeRequest $request, int $taskId, int $employeeId): JsonResponse
    {
        $this->employeeService->updateEmployeeTask(
            $taskId,
            $employeeId,
            $request->validated()
        );

        return response()->json([
            'message' => 'Data pegawai berhasil diperbarui dan diakumulasikan.',
        ]);
    }
}
