<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(Request $request): View
    {
        $action = $request->get('action');
        $histories = History::when($action, fn($q) => $q->where('action', 'like', "%$action%"))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.histories.index', [
            'histories' => $histories,
            'filters' => ['action' => $action],
        ]);
    }
}
