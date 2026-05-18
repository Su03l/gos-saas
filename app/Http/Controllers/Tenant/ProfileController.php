<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Upload and store the user's physical signature image.
     */
    public function uploadSignature(Request $request): RedirectResponse
    {
        $request->validate([
            'signature_image' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

        /** @var User $user */
        $user = $request->user();

        $user->addMediaFromRequest('signature_image')
            ->toMediaCollection('signatures');

        return redirect()->back()->with('success', 'Physical signature image uploaded successfully.');
    }
}
