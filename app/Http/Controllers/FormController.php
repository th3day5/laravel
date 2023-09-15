<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TokenGenerateRequest;
use App\Models\Form;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use setasign\Fpdi\Fpdi;

class FormController extends Controller
{
    public function tokenGenerate(TokenGenerateRequest $request): JsonResponse
    {
        try {
            $token = Str::random(30);

            $name = $request->validated()["name"];

            $formToken = Form::create([
                "token" => $token,
                "name" => $name,
            ]);

            $existingTemplatePath = resource_path("views/forms/templates/{$name}.blade.php");

            $newFormPath = resource_path("views/forms/{$token}.blade.php");

            if (file_exists($existingTemplatePath)) {
                copy($existingTemplatePath, $newFormPath);
            } else {
                throw new \Exception("Template not found: $existingTemplatePath");
            }

            return response()->json([
                "token" => $formToken->token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ]);
        }
    }

    public function showForm(string $token): View
    {
        return view("forms.$token", [
            "token" => $token,
        ]);
    }

    public function submitForm(Request $request, $token)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $data = $request->except('_token', '_method');

        $html = view('forms/templates/'."test", [
            "token" => $token,
            "data" => $data,
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfPath = storage_path('app/forms/'.$token.'.pdf');

        Storage::makeDirectory('app/forms');

        file_put_contents($pdfPath, $dompdf->output());

        return redirect()->back()->with('success', 'Form submitted successfully and PDF generated.');
    }

    public function downloadPdf(string $token)
    {
        $pdfPath = storage_path('app/forms/'.$token.'.pdf');
        if (!file_exists($pdfPath)) {
            return view('errors.not_found')->with('message', 'PDF not found.');
        } else {
            return response()->download($pdfPath);
        }
    }

    public function fillPDFFile(Request $request)
    {
        $fpdi = new FPDI;

        include(resource_path('/views/forms/positions.php'));

        $count = $fpdi->setSourceFile(
            resource_path('/views/forms/templates/RG-Recruitment-LTD-Contract-JUNE-2021-07-06.pdf')
        );

        $token = $request->input('token');
        $formDataJson = $request->input('form_data');
        $signatureBase64 = $request->only('signature_base64');

        if (!empty($signatureBase64)) {
            $formDataArray = Form::where('token', $token)->first()->data;

            $formDataArray = json_decode($formDataArray, true);

            foreach ($formDataArray as &$formData) {
                $formData['signature_base64'] = $signatureBase64['signature_base64'];
            }

            Form::where('token', $token)->update([
                'data' => $formDataArray,
            ]);
        } else {
            Form::where('token', $token)->update([
                'data' => $formDataJson,
            ]);
        }

        $formDataArray = Form::where('token', $token)->first()->data;

        $formDataArray = json_decode($formDataArray, true);

        for ($pageNumber = 1; $pageNumber <= $count; $pageNumber++) {
            $template = $fpdi->importPage($pageNumber);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $fpdi->useTemplate($template);

            $fpdi->SetFont("helvetica", "", 15);
            $fpdi->SetTextColor(0, 0, 0);

            if (isset($formDataArray[$pageNumber]) && is_array($formDataArray[$pageNumber])) {
                $stepData = $formDataArray[$pageNumber];
                foreach ($stepData as $variableName => $text) {
                    if (isset($data[$pageNumber][$variableName])) {
                        $position = $data[$pageNumber][$variableName];
                        $left = $position["x"];
                        $top = $position["y"];

                        if ($variableName === 'signature_base64') {
                            $image = base64_encode(file_get_contents($request->input('signature_base64')));

                            $imagePath = storage_path('app/public/'.$token.'.png');
                            file_put_contents($imagePath, base64_decode($image));

                            $fpdi->Image($imagePath, $left, $top, 50, 20);
                        } else {
                            if (!empty($text)) {
                                $fpdi->Text($left, $top, $text);
                            }
                        }
                    }
                }
            }
        }

        $outputFilePath = storage_path('app/public/'.$token.'.pdf');

        $fpdi->Output($outputFilePath, 'F');

        return redirect('/preview/'.$token);
    }

    public function previewPdf(string $token)
    {
        $pdfPath = "{$token}.pdf";

        return view('forms.preview', [
            'pdfPath' => $pdfPath,
            "token" => $token,
        ]);
    }
}
