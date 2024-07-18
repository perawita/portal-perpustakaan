<?php

namespace App\Services;

class Upload_img
{
    private $targetDir;
    private $uploadOk;
    private $allowedExtensions;

    public function __construct($targetDir)
    {
        $this->targetDir = rtrim($targetDir, '/') . '/';
        $this->uploadOk = 1;
        $this->allowedExtensions = array("jpg", "jpeg", "png", "gif");
    }

    private function generateRandomFileName($extension)
    {
        $randomString = bin2hex(random_bytes(100));
        $maxLength = 30 - strlen($extension) - 1;
        return substr($randomString, 0, $maxLength) . '.' . $extension;
    }

    public function handleUpload($file)
    {
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            $this->uploadOk = 0;
            return "File is not an image.";
        }

        if ($file["size"] > 500000) {
            $this->uploadOk = 0;
            return "Sorry, your file is too large.";
        }

        if (!in_array($imageFileType, $this->allowedExtensions)) {
            $this->uploadOk = 0;
            return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        if ($this->uploadOk == 0) {
            return "Sorry, your file was not uploaded.";
        } else {
            $fileName = $this->generateRandomFileName($imageFileType);
            $targetFile = $this->targetDir . $fileName;

            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                return $fileName;
            } else {
                return "Sorry, there was an error uploading your file.";
            }
        }

        return null;
    }

    public function deleteImage($fileName)
    {
        $filePath = $this->targetDir . $fileName;

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                return "File successfully deleted.";
            } else {
                return "Error: Unable to delete the file.";
            }
        } else {
            return "Error: File old not found.";
        }
    }
}
