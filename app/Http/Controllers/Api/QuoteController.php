<?php

namespace App\Http\Controllers\Api;

use App\Actions\Quotes\CreateQuote;
use App\Actions\Quotes\ExportQuotePdf;
use App\Actions\Quotes\UpdateQuote;
use App\Data\Quotes\QuoteData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Quote\StoreQuoteRequest;
use App\Http\Requests\Api\Quote\UpdateQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class QuoteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Quote::class, 'quote');
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $quotes = Quote::query()
            ->with(['company:id,name', 'opportunity:id,title'])
            ->when(
                ! $user->isAdmin(),
                fn ($query) => $query->where('created_by', $user->id),
            )
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where('status', (string) $request->string('status')),
            )
            ->when(
                $request->filled('company_id'),
                fn ($query) => $query->where('company_id', (int) $request->integer('company_id')),
            )
            ->when(
                $request->filled('q'),
                fn ($query) => $query->where('quote_number', 'like', '%'.$request->string('q').'%'),
            )
            ->latest('id')
            ->paginate((int) $request->integer('per_page', 15));

        return response()->json($quotes);
    }

    public function store(StoreQuoteRequest $request, CreateQuote $createQuote): JsonResponse
    {
        $quote = $createQuote->handle(
            QuoteData::fromArray($request->validated()),
            $request->user(),
        );

        return response()->json($quote, 201);
    }

    public function show(Quote $quote): JsonResponse
    {
        return response()->json($quote->load(['items', 'company:id,name', 'opportunity:id,title', 'createdBy:id,name']));
    }

    public function update(UpdateQuoteRequest $request, Quote $quote, UpdateQuote $updateQuote): JsonResponse
    {
        $updated = $updateQuote->handle($quote, QuoteData::fromArray($request->validated()));

        return response()->json($updated);
    }

    public function destroy(Quote $quote): JsonResponse
    {
        $quote->delete();

        return response()->json(['message' => 'Quote deleted']);
    }

    public function exportPdf(Quote $quote, ExportQuotePdf $exportQuotePdf): BinaryFileResponse|JsonResponse
    {
        $this->authorize('view', $quote);

        try {
            return $exportQuotePdf->handle($quote);
        } catch (\RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 501);
        }
    }
}
