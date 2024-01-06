<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Categories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function index()
    {
        $count = Documents::where('user_id', Auth::user()->id)->count();
        $documentsData = Documents::where('user_id', Auth::user()->id)->get();
        return view('user.documents.index', [
            'documentCount' => $count,
            'documentData' => $documentsData,

        ]);
    }

    public function DocumentAdd()
    {
        // $userCategoryData = Categories::where('user_id', Auth::user()->id)->get();
        // return view('user.document.add', [
        //     'userCategoryData' => $userCategoryData
        // ]);
        return view('user.documents.add');
    }

    public function documentAddSave(Request $request)
    {

        $status = $request->input('status') === 'visible';


        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'pdf' => 'file|mimes:pdf|max:10000', // Validate max file size: 10MB
            'status' => 'required|string',
            'upload_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $status = $request->input('status') === 'visible';

            $documentData = [
                'user_id' => Auth::user()->id,
                'title' => $request->input('title'),
                'status' => $status,
                'upload_date' => $request->input('upload_date'),
            ];

            if ($request->hasFile('pdf')) {
                $pdfName = time() . Auth::user()->id . "." . $request->file('pdf')->extension();
                Storage::disk('pdf')->put($pdfName, file_get_contents($request->file('pdf')->getRealPath()));
                $documentData['pdf'] = $pdfName;
                $hash = hash('sha256', $pdfName . time());
                $documentData['hash'] = $hash;
            } else {
                return redirect()->back()->withErrors(['error' => 'Document is not added.']);
            }
            $document = Documents::create($documentData);
            return redirect()->route('document');
        }
    }

    public function updateStatus(Request $request, $documentId)
    {
        $document = Documents::findOrFail($documentId);
        // 1 - visible, 0 - invisible
        $document->status = $request->status === 'visible';
        $document->save();

        //return redirect()->route('document')->with('success', 'Document status updated successfully!');

         // Json for the AJAX
         return response()->json(['success' => 'Document status updated successfully!']);
    }


    public function DocumentDelete(Request $request)
    {
        $document = Documents::find($request->input('id'));
        if ($document) {
            if ($document->user_id === Auth::user()->id || Auth::user()->role == 'admin') {

                if ($document->image) {
                    Storage::disk('image')->delete($document->image);
                }

                if ($document->pdf) {
                    Storage::disk('pdf')->delete($document->pdf);
                }

                $document->delete();

                if(Auth::user()->role == 'admin'){
                    return redirect()->route('user.documents', ['user_id' => $document->user_id])
                                    ->with('success', 'The document was deleted successfully!');
                } else {
                    return redirect()->route('documents.index')
                                    ->with('success', 'The document was deleted successfully!');
                }
            } else {
                return redirect()->route('home')->withErrors(['error' => 'Unauthorized action.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Document not found.']);
        }
    }


    public function documentEdit($documentId)
    {
        $data = ['documentId' => $documentId];
        $rules = [
            'documentId' => 'required|integer',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $document = Documents::find($documentId);
            if ($document) {
                if ($document->user_id === Auth::user()->id || Auth::user()->role == 'admin') {
                    //$userCategoryData = Categories::where('user_id', Auth::user()->id)->get();
                    return view('user.documents.edit', [
                        'data' => $document,
                        //'userCategoryData' => $userCategoryData
                    ]);
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->back()->withErrors(['error' => 'Category not found.']);
            }

        }
    }

    public function documentUpdateSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'status' => 'required|string|max:20'

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $documentData = [
                'title' => $request->input('title'),
                'status' => $request->input('status'),
            ];

            $old = Documents::find($request->input('id'));

            if ($request->hasFile('pdf')) {
                Storage::disk('pdf')->delete($old->pdf);
                $pdfName = time() . Auth::user()->id . "." . $request->file('pdf')->extension();
                Storage::disk('pdf')->put($pdfName, file_get_contents($request->file('pdf')->getRealPath()));
                $documentData['pdf'] = $pdfName;
            }

            $document = Documents::find($request->input('id'));

            if (!$document) {
                return redirect()->back()->with('error', 'Document is not found!');
            }

            $document->update($documentData);

            if (Auth::user()->role == 'admin') {
                return redirect()->route('user.documents', ['user_id' => $old->user_id]);
            } else {
                return redirect()->route('document')->with('success', 'Document updated successfully!');
            }


        }
    }

    public function DocumentDetails($id)
    {
        $documentsData = Documents::where('id', $id)->first();

        if ($documentsData->user_id == Auth::user()->id || Auth::user()->role == 'admin') {
            return view('user.documents.details', [
                'documentData' => $documentsData
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function specifyCategory($category)
    {
        $categoryid = Categories::where('name', $category)
            ->where('user_id', Auth::user()->id)
            ->pluck('id')
            ->first();

        $count = Documents::where('id', $categoryid)
            ->where('user_id', Auth::user()->id)
            ->count();

        $documentData = Documents::where('category_id', $categoryid)
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('welcome', [
            'documentCount' => $count,
            'documentData' => $documentData
        ]);
    }



}
