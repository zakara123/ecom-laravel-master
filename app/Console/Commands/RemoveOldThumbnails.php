<?php

namespace App\Console\Commands;

use App\Models\ProductVariationThumbnail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveOldThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:OldThumbnails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes old product variation thumbnails from both DB and file system, keeping only the latest uploaded image';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve all product variation IDs
        $variationIds = ProductVariationThumbnail::select('product_variation_id')->distinct()->pluck('product_variation_id');

        // Loop through each product variation
        foreach ($variationIds as $variationId) {
            // Get all thumbnails for the variation, ordered by creation time (desc)
            $thumbnails = ProductVariationThumbnail::where('product_variation_id', $variationId)
                ->orderBy('created_at', 'desc')
                ->get();

            if ($thumbnails->count() > 1) {
                // Keep the latest thumbnail and remove the rest
                $latestThumbnail = $thumbnails->shift(); // This keeps the latest one and removes it from the collection

                foreach ($thumbnails as $thumbnail) {
                    // Delete the file from the filesystem
                    $filePath = public_path($thumbnail->src);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }

                    // Delete the thumbnail record from the database
                    $thumbnail->delete();
                }

                $this->info("Cleaned up thumbnails for variation ID: $variationId");
            }
        }

        $this->info('Thumbnail cleanup completed.');
        return 0;
    }
}
