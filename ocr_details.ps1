
Add-Type -AssemblyName System.Runtime.WindowsRuntime
$asTaskGeneric = [System.WindowsRuntimeSystemExtensions].GetMethods() | Where-Object { $_.Name -eq 'AsTask' -and $_.GetParameters().Count -eq 1 -and $_.GetParameters()[0].ParameterType.Name -eq 'IAsyncOperation`1' }

function Await($WinRtTask, $ResultType) {
    $asTask = $asTaskGeneric.MakeGenericMethod($ResultType)
    $netTask = $asTask.Invoke($null, @($WinRtTask))
    $netTask.Wait(-1) | Out-Null
    $netTask.Result
}

[Windows.Globalization.Language,Windows.Globalization,ContentType=WindowsRuntime] | Out-Null
[Windows.Graphics.Imaging.BitmapDecoder,Windows.Graphics.Imaging,ContentType=WindowsRuntime] | Out-Null
[Windows.Media.Ocr.OcrEngine,Windows.Media.Ocr,ContentType=WindowsRuntime] | Out-Null
[Windows.Storage.StorageFile,Windows.Storage,ContentType=WindowsRuntime] | Out-Null

$engine = [Windows.Media.Ocr.OcrEngine]::TryCreateFromUserProfileLanguages()

foreach ($crop in $args) {
    Write-Output ("`n==== " + [System.IO.Path]::GetFileName($crop) + " ====")
    $file = Await ([Windows.Storage.StorageFile]::GetFileFromPathAsync($crop)) ([Windows.Storage.StorageFile])
    $stream = Await ($file.OpenAsync([Windows.Storage.FileAccessMode]::Read)) ([Windows.Storage.Streams.IRandomAccessStream])
    $decoder = Await ([Windows.Graphics.Imaging.BitmapDecoder]::CreateAsync($stream)) ([Windows.Graphics.Imaging.BitmapDecoder])
    $bitmap = Await ($decoder.GetSoftwareBitmapAsync()) ([Windows.Graphics.Imaging.SoftwareBitmap])
    $result = Await ($engine.RecognizeAsync($bitmap)) ([Windows.Media.Ocr.OcrResult])

    foreach ($line in $result.Lines) {
        $minX = 999999
        $minY = 999999
        $maxX = 0
        $maxY = 0
        foreach ($w in $line.Words) {
            if ($w.BoundingRect.X -lt $minX) { $minX = $w.BoundingRect.X }
            if ($w.BoundingRect.Y -lt $minY) { $minY = $w.BoundingRect.Y }
            $rx = $w.BoundingRect.X + $w.BoundingRect.Width
            $ry = $w.BoundingRect.Y + $w.BoundingRect.Height
            if ($rx -gt $maxX) { $maxX = $rx }
            if ($ry -gt $maxY) { $maxY = $ry }
        }
        Write-Output ("  Y={0,3}, X={1,3}, W={2,3}, H={3,2}: {4}" -f [int]$minY, [int]$minX, [int]($maxX - $minX), [int]($maxY - $minY), $line.Text)
    }
}
