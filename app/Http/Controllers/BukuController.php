<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $TableBuku = Buku::orderBy('time', 'DESC')->get();
        $response = [
            'message' => 'List Buku order by time',
            'data' => $TableBuku
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku' => ['required'],
            'gendre' => ['required'],
            'penerbit' => ['required'],
            'alamat_penerbit' => ['required'],
            'pengarang' => ['required'],

        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $TableBuku = Buku::create($request->all());
            $response = [
                'message' => 'Buku created',
                'data' => $TableBuku
            ];

            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $TableBuku = Buku::findOrFail($id);
        $response = [
            'message' => 'Detail of Buku resource',
            'data' => $TableBuku
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $TableBuku = Buku::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'judul_buku' => ['required'],
            'gendre' => ['required'],
            'penerbit' => ['required'],
            'alamat_penerbit' => ['required'],
            'pengarang' => ['required'],
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $TableBuku->update($request->all());
            $response = [
                'message' => 'Table Buku Updated',
                'data' => $TableBuku
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $TableBuku = Buku::findOrFail($id);

        try {
            $TableBuku->delete();
            $response = [
                'message' => 'Data Buku Deleted'
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}

