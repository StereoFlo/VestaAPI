<?php

namespace VestaAPI\Services;

trait FileSystem
{
    /**
     * @param        $src
     * @param        $dst
     *
     * @return mixed
     */
    public function moveFile($src, $dst)
    {
        return $this->setReturnCode(self::RETURN_CODE_NO)->toArray($this->send('v-move-fs-file', $this->getUserName(), $src, $dst));
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function openFile($path = '')
    {
        $path = '/home/'.$this->getUserName().'/'.$path;
        return $this->setReturnCode(self::RETURN_CODE_NO)->toArray($this->send('v-open-fs-file', $this->getUserName(), $path));
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function addDir($path)
    {
        return $this->setReturnCode(self::RETURN_CODE_NO)->toArray($this->send('v-add-fs-directory', $this->getUserName(), $path));
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function addFile($path)
    {
        return $this->setReturnCode(self::RETURN_CODE_NO)->toArray($this->send('v-add-fs-file', $this->getUserName(), $path));
    }

    /**
     * @param        $srcFile
     * @param        $permissions
     *
     * @return mixed
     */
    public function changePermission($srcFile, $permissions)
    {
        $srcFile = '/home/'.$this->getUserName().'/'.$srcFile;
        return $this->setReturnCode('no')->toArray($this->send('v-change-fs-file-permission', $this->getUserName(), $srcFile, $permissions));
    }

    /**
     * @param $srcDir
     * @param $dstDir
     *
     * @return mixed
     */
    public function copyDir($srcDir, $dstDir)
    {
        return $this->setReturnCode(self::RETURN_CODE_NO)->toArray($this->send('v-copy-fs-directory', $this->getUserName(), $srcDir, $dstDir));
    }

    /**
     * @param $srcDir
     * @param $dstDir
     *
     * @return mixed
     */
    public function copyFile($srcDir, $dstDir)
    {
        return $this->setReturnCode(self::RETURN_CODE_NO)->toArray($this->send('v-copy-fs-file', $this->getUserName(), $srcDir, $dstDir));
    }

    /**
     * @param        $dstDir
     *
     * @return mixed
     */
    public function deleteDir($dstDir)
    {
        $dstDir = '/home/'.$this->getUserName().'/'.$dstDir;
        return $this->setReturnCode(self::RETURN_CODE_NO)->toArray($this->send('v-delete-fs-dir', $this->getUserName(), $dstDir));
    }

    /**
     * @param $dstFile
     *
     * @return mixed
     */
    public function deleteFile($dstFile)
    {
        $dstFile = '/home/'.$this->getUserName().'/'.$dstFile;
        return $this->setReturnCode(self::RETURN_CODE_NO)->toArray($this->send('v-delete-fs-file', $this->getUserName(), $dstFile));
    }

    /**
     * @param $srcFile
     * @param $dstDir
     *
     * @return mixed
     */
    public function extractArchive($srcFile, $dstDir)
    {
        return $this->setReturnCode(self::RETURN_CODE_NO)->toArray($this->send('v-extract-fs-archive', $this->getUserName(), $srcFile, $dstDir));
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function listDirectory($path = '')
    {
        $path = '/home/'.$this->getUserName().'/'.$path;
        $responseVesta = $this->setReturnCode(self::RETURN_CODE_NO)->toArray($this->send('v-list-fs-directory', $this->getUserName(),  $path));

        return $this->parseListing($responseVesta);
    }

    /**
     * @param $raw
     *
     * @return array
     */
    public function parseListing($raw)
    {
        $raw = explode(PHP_EOL, $raw);
        $raw = array_filter($raw);
        $data = [];

        foreach ($raw as $o) {
            $info = explode(self::FILESYSTEM_DELIMITER, $o);
            if (empty($info)) {
                continue;
            }
            $value = [
                'type'        => $info[self::POSITION_TYPE],
                'permissions' => $info[self::POSITION_PERMISSIONS],
                'date'        => $info[self::POSITION_DATE],
                'time'        => $info[self::POSITION_TIME],
                'owner'       => $info[self::POSITION_OWNER],
                'group'       => $info[self::POSITION_GROUP],
                'size'        => $info[self::POSITION_SIZE],
                'name'        => (!empty($info[self::POSITION_NAME])) ? $info[self::POSITION_NAME] : '../',
            ];
            array_push($data, $value);
        }

        return $data;
    }
}
