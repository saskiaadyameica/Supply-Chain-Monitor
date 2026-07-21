<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    private $file;

    public function __construct()
    {
        $this->file = storage_path('app/ports.csv');
    }

    public function index()
    {
        $ports = [];

        if (($handle = fopen($this->file, 'r')) !== false) {

            $header = fgetcsv($handle);

            $id = 0;

            while (($row = fgetcsv($handle)) !== false) {

                $ports[] = [
                    'id' => $id++,
                    'PORT_NAME' => $row[0],
                    'COUNTRY' => $row[1],
                    'LATITUDE' => $row[2],
                    'LONGITUDE' => $row[3],
                ];

            }

            fclose($handle);
        }

        return view('admin.dataset.index', compact('ports'));
    }

    public function create()
    {
        return view('admin.dataset.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'PORT_NAME' => 'required',
            'COUNTRY' => 'required|max:2',
            'LATITUDE' => 'required',
            'LONGITUDE' => 'required',
        ]);

        $rows = [];

        if (($handle = fopen($this->file, 'r')) !== false) {

            while (($row = fgetcsv($handle)) !== false) {
                $rows[] = $row;
            }

            fclose($handle);
        }

        $rows[] = [
            $request->PORT_NAME,
            strtoupper($request->COUNTRY),
            $request->LATITUDE,
            $request->LONGITUDE,
        ];

        $handle = fopen($this->file, 'w');

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return redirect()
            ->route('admin.dataset.index')
            ->with('success', 'Port added successfully.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'dataset' => 'required|mimes:csv,txt',
        ]);

        $request->file('dataset')->storeAs(
            '',
            'ports.csv'
        );

        return redirect()
            ->route('admin.dataset.index')
            ->with('success', 'Dataset uploaded successfully.');
    }

    public function edit($id)
    {
        $ports = [];

        if (($handle = fopen($this->file, 'r')) !== false) {

            fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                $ports[] = $row;
            }

            fclose($handle);
        }

        if (!isset($ports[$id])) {
            abort(404);
        }

        $port = [
            'id' => $id,
            'PORT_NAME' => $ports[$id][0],
            'COUNTRY' => $ports[$id][1],
            'LATITUDE' => $ports[$id][2],
            'LONGITUDE' => $ports[$id][3],
        ];

        return view('admin.dataset.edit', compact('port'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'PORT_NAME' => 'required',
            'COUNTRY' => 'required|max:2',
            'LATITUDE' => 'required',
            'LONGITUDE' => 'required',
        ]);

        $rows = [];

        if (($handle = fopen($this->file, 'r')) !== false) {

            while (($row = fgetcsv($handle)) !== false) {
                $rows[] = $row;
            }

            fclose($handle);
        }

        if (!isset($rows[$id + 1])) {
            abort(404);
        }

        $rows[$id + 1] = [
            $request->PORT_NAME,
            strtoupper($request->COUNTRY),
            $request->LATITUDE,
            $request->LONGITUDE,
        ];

        $handle = fopen($this->file, 'w');

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return redirect()->route('admin.dataset.index')
            ->with('success', 'Port updated successfully.');
    }

    public function destroy($id)
    {
        $rows = [];

        if (($handle = fopen($this->file, 'r')) !== false) {

            while (($row = fgetcsv($handle)) !== false) {
                $rows[] = $row;
            }

            fclose($handle);
        }

        if (!isset($rows[$id + 1])) {
            abort(404);
        }

        unset($rows[$id + 1]);

        $handle = fopen($this->file, 'w');

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return redirect()->route('admin.dataset.index')
            ->with('success', 'Port deleted successfully.');
    }

}