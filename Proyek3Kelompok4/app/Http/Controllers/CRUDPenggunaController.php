<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Models;

class CRUDPenggunaController extends Controller
{
    public function index($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $models = Models::where('users_id', $user->id)->get();
        return view('crudmodels.index', compact('user', 'models'));
    }

    public function create($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        return view('crudmodels.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'gambar.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::findOrFail($request->id);
        $directory = public_path('assets/img/labeled_images/' . $user->name);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $savedFiles = [];
        foreach ($request->file('gambar') as $file) {
            $imageName = $this->getIncrementalImageName($directory, '.jpg');
            $file->move($directory, $imageName);
            $savedFiles[] = 'assets/img/labeled_images/' . $user->name . '/' . $imageName;
        }

        foreach ($savedFiles as $filePath) {
            $model = new Models([
                'users_id' => $request->id,
                'gambar' => $filePath
            ]);
            $model->save();
        }

        return redirect()->route('models.index', ['id' => $request->id])
            ->with('success', 'Model created successfully.');
    }

    private function getIncrementalImageName($directory, $extension, $count = 1)
    {
        $fileName = $count . $extension;
        if (file_exists($directory . '/' . $fileName)) {
            return $this->getIncrementalImageName($directory, $extension, $count + 1);
        }
        return $fileName;
    }

    public function destroy(Models $models)
    {
        $users_id = User::where('id', $models->users_id)->firstOrFail();

        if ($models->gambar) {
            $photoPath = public_path($models->gambar);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }

        $models->delete();

        return redirect()->route('models.index', ['id' => $users_id->id])
            ->with('success', 'User deleted successfully');
    }
}
