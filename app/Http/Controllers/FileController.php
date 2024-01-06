<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function showpdf($pdfName)
    {
        $file = storage_path('app/private/pdf/' . $pdfName);
        $documentData = Documents::where('pdf', $pdfName)->first();
        if ($documentData->user_id == Auth::user()->id || Auth::user()->role == 'admin')
        {
            return response()->file($file, [
                'Content-Disposition' => 'inline; filename="' . $pdfName . '"'
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function showPdfByHash($hash)
    {
        $document = Documents::where('hash', $hash)->firstOrFail();

        // here is the symbolic link to:
        // 'ln public/storage/pdf -> app/private/pdf'
        // storage/app/private/pdf

        if ($document->status != 1) {
            // Redirect or show an error message if the document is not visible
            return redirect()->away('https://en.bridge.pl/index.php');
        }
        $pdfUrl = Storage::url('pdf/' . $document->pdf);

        // Fetch previous and next documents
        $previousDocument = Documents::where('id', '<', $document->id)
                                    ->where('status', 1)
                                    ->orderBy('id', 'desc')
                                    ->first();

        $nextDocument = Documents::where('id', '>', $document->id)
                                ->where('status', 1)
                                ->orderBy('id', 'asc')
                                ->first();

        // Define previous and next hash, even if documents are null
        $previousHash = $previousDocument ? $previousDocument->hash : null;
        $nextHash = $nextDocument ? $nextDocument->hash : null;

        return view('articles.article', compact('pdfUrl', 'previousHash', 'nextHash', 'previousDocument', 'nextDocument'));
    }



    // Example server-side method in a controller
    public function checkFileExistence(Request $request) {
        $fileName = $request->query('fileName');
        $exists = Storage::disk('pdf')->exists($fileName); 
        return response()->json(['exists' => $exists]);
    }

}
