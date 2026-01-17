<?php

namespace App\Http\Controllers;

use App\Models\HarvestBatch;

class HarvestBatchController extends Controller
{
    /**
     * GET /harvests
     * Stránka so všetkými zbierkami
     */
    public function index()
    {
        $batches = HarvestBatch::withCount('products')
            ->orderByDesc('harvested_at')
            ->get();

        return view('harvests.index', compact('batches'));
    }

    /**
     * GET /harvests/{harvestBatch}
     * Detail zbierky s produktami
     */
    public function show(HarvestBatch $harvestBatch)
    {
        $harvestBatch->load(['products' => function ($query) {
            $query->where('is_active', true);
        }]);

        return view('harvests.show', compact('harvestBatch'));
    }
}

