<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditDocument;
use App\Http\Requests\EditDocumentCash;
use App\Http\Requests\EditProduct;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\StoreDocumentCash;
use App\Http\Requests\StoreProduct;
use App\Models\Document;
use App\Models\DocumentCash;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Http\Request;
use PDF;

class DocumentsCashController extends Controller
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
        $documents = DocumentCash::sortable()->paginate($pages);

        return view('product/document-cash/documents', ['documents' => $documents]);
    }

    public function newDocument(Request $request)
    {

        return view('product/document-cash/new');
    }

    public function storeDocument(StoreDocumentCash $request)
    {
        DocumentCash::create([
            'description' => $request->get('description'),
            'output_type' => $request->get('output_type')
        ]);

        return redirect('product/documents-cash')->with([
            'status' => 'Nuevo documento efectivo agregado exitosamente'
        ]);
    }

    public function editDocument($id)
    {
        $document = DocumentCash::find($id);

        if ($document) {

            return view('product/document-cash/edit', ['document' => $document]);
        }

        return abort(404);
    }

    public function saveEditDocument(EditDocumentCash $request, $id)
    {
        $document = DocumentCash::find($id);

        if ($document) {
            $document->description = $request->get('description');
            $document->output_type = $request->get('output_type');
            $document->save();

            return redirect('product/documents-cash')->with([
                'status' => 'Documento efectivo actualizado exitosamente'
            ]);
        }

        return abort(404);
    }

    public function deleteDocument($id)
    {
        $document = DocumentCash::find($id);

        if ($document) {
            return view('product/document-cash/delete', ['document' => $document]);
        }

        return abort(404);
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
        $document = DocumentCash::find($id);

        if ($document) {
            $document->delete();

            return redirect('product/documents-cash')->with([
                'status' => 'Documento Efectivo eliminado exitosamente'
            ]);
        }

        return response('', 404);
    }
}
