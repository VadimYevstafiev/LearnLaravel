<?php

namespace Tests\Unit\Services;

use App\Services\FileStorageService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileStorageServiceTest extends TestCase
{
    public function test_file_upload()
    {
        $filePath = $this->uploadFile();
        $this->assertTrue(\Storage::has($filePath));
    }

    public function test_file_upload_with_additional_path()
    {
        $additionalPath = 'test\path';
        $filePath = $this->uploadFile($additionalPath);

        $this->assertStringContainsString($additionalPath, $filePath);
        $this->assertTrue(\Storage::has($filePath));
    }

    public function test_remove_file()
    {
        $filePath = $this->uploadFile();
        $this->assertTrue(\Storage::has($filePath));
        FileStorageService::remove($filePath);
        $this->assertFalse(\Storage::has($filePath));
    }

    protected function uploadFile($additionalPath = '', $fileName = 'image.png'): string
    {
        $file = UploadedFile::fake()->create($fileName);
        return FileStorageService::upload($file, $additionalPath);
    }
}
