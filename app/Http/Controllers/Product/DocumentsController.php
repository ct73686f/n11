<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditDocument;
use App\Http\Requests\EditProduct;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\StoreProduct;
use App\Models\Document;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Http\Request;
use PDF;

class DocumentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function documents(Request $request)
    {
        $pages     = $request->get('pages', 10);
        $documents = Document::sortable()->paginate($pages);

        return view('product/document/documents', ['documents' => $documents]);
    }

    public function newDocument(Request $request)
    {

        return view('product/document/new');
    }

    public function storeDocument(StoreDocument $request)
    {
        Document::create([
            'description' => $request->get('description'),
            'output_type' => $request->get('output_type')
        ]);

        return redirect('product/documents')->with([
            'status' => 'Nuevo documento agregado exitosamente'
        ]);
    }

    public function editDocument($id)
    {
        $document = Document::find($id);

        if ($document) {

            return view('product/document/edit', ['document' => $document]);
        }

        return response('', 404);
    }

    public function saveEditDocument(EditDocument $request, $id)
    {
        $document = Document::find($id);

        if ($document) {
            $document->description = $request->get('description');
            $document->output_type = $request->get('output_type');
            $document->save();

            return redirect('product/documents')->with([
                'status' => 'Documento actualizado exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteDocument($id)
    {
        $document = Document::find($id);

        if ($document) {
            return view('product/document/delete', ['document' => $document]);
        }

        return response('', 404);
    }

    public function viewDocumentPDF($id)
    {
        $document = Document::find($id);
        $total    = $document->movements()->sum('total');

        if ($document) {
            $pdf = PDF::loadView('product/document/pdf', ['document' => $document, 'total' => $total]);
            return $pdf->stream();
        }

        return response('', 404);
    }

    public function proceedDeleteDocument($id)
    {
        $document = Document::find($id);

        if ($document) {
            $document->delete();

            return redirect('product/documents')->with([
                'status' => 'Documento eliminado exitosamente'
            ]);
        }

        return response('', 404);
    }
}
