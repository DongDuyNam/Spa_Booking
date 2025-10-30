<?php

namespace App\Http\Controllers\Api\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

trait BuildsApiQueries
{
    protected function applyCommon(Builder $query, Request $request, array $searchIn = [], array $dateRange = [], array $equals = [], array $relations = [], string $defaultSort = 'id', string $defaultOrder = 'desc')
    {
        if (!empty($relations)) {
            $query->with($relations);
        }

        if ($request->filled('search') && !empty($searchIn)) {
            $search = $request->input('search');
            $query->where(function ($q) use ($searchIn, $search) {
                foreach ($searchIn as $i => $col) {
                    $i === 0 ? $q->where($col, 'like', "%{$search}%") : $q->orWhere($col, 'like', "%{$search}%");
                }
            });
        }

        foreach ($equals as $col) {
            if ($request->filled($col)) {
                $query->where($col, $request->input($col));
            }
        }

        if (!empty($dateRange)) {
            [$fromCol, $toCol, $col] = $dateRange + [null, null, null];
            if ($fromCol && $request->filled($fromCol)) {
                $query->whereDate($col, '>=', $request->input($fromCol));
            }
            if ($toCol && $request->filled($toCol)) {
                $query->whereDate($col, '<=', $request->input($toCol));
            }
        }

        $sort = $request->input('sort', $defaultSort);
        $order = $request->input('order', $defaultOrder);
        $query->orderBy($sort, $order);

        $limit = (int) $request->input('limit', 10);
        return $query->paginate($limit);
    }

    protected function jsonPage($paginator): JsonResponse
    {
        return response()->json([
            'data' => $paginator->items(),
            'meta' => [
                'total' => $paginator->total(),
                'page' => $paginator->currentPage(),
                'limit' => $paginator->perPage(),
                'last_page' => $paginator->lastPage(),
            ],
        ]);
    }
}
