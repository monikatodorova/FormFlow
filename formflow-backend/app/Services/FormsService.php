<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Form;
use App\Models\Recipient;
use App\Models\Submission;
use App\Repositories\FormsRepository;
use App\Repositories\ColorsRepository;
use App\Repositories\NotificationsRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;

class FormsService {

    /**
     * Returns all projects for current user.
     * @return Response
     */
    public static function getAllFormsForProject(Project $project) {
        return new Response([
            'status' => 'success',
            'forms' => FormsRepository::getAllFormsForProject($project),
        ], 200);
    }

    /**
     * Creates new form with the provided details.
     * @param Project $project
     * @param array $details
     * @param bool $returnObject
     * @return Response | Form
     */
    public static function createForm(Project $project, array $details, bool $returnObject = false) {
        try {
            self::validateRequiredFields($details);
        } catch (ValidationException $e) {
            if($returnObject) return null;
            return new Response([
                'status' => 'error',
                'message' => $e->getResponse(),
            ], 400);
        }

        $fields = isset($details['fields']) ? json_encode($details['fields']) : null;
        $color = ColorsRepository::getColor($details['color'] ?? null);
        $form = FormsRepository::createForm($project, $color, [
            'name' => $details['name'],
            'form_type' => $details['form_type'],
            'fields' => $fields,
        ]);

        Recipient::create([
            'email' => 'test@email.com',
            'vefiried' => 1,
            'form_id' => $form->getId(),
        ]);

        if($returnObject) return $form;
        return new Response([
            'status' => 'success',
            'form' => FormsRepository::details($form),
        ]);
    }

     /**
     * Provides the details for the current form.
     * @param Form $form
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public static function details(Form $form) {
        return FormsRepository::details($form);
    }

    /**
     * Provides the details for the current form.
     * @param Form $form
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public static function preview(Form $form) {
        return FormsRepository::preview($form);
    }

    /**
     * Updates the provided attributes for the form.
     * @param Form $form
     * @param array $details
     * @return Response
     */
    public static function updateForm(Form $form, array $details) {
        if(isset($details['name'])) FormsRepository::updateAttribute($form, 'name', $details['name']);
        if(isset($details['form_type'])) FormsRepository::updateAttribute($form, 'form_type', $details['form_type']);
        if(isset($details['fields'])) FormsRepository::updateAttribute($form, 'fields', $details['fields']);
        if(isset($details['color_id'])) FormsRepository::updateAttribute($form, 'color_id', ColorsRepository::getColor($details['color_id'])->getId());

        return new Response([
            'status' => 'success',
            'form' => FormsRepository::details($form),
        ]);
    }

     /**
     * Deletes the provided form.
     * @param Form $form
     * @return Response
     */
    public static function delete(Form $form) {
        FormsRepository::delete($form);
        return new Response([
            'status' => 'success',
            'message' => 'Form has been deleted',
        ]);
    }

    /**
     * Validates the required fields for new form.
     * @throws ValidationException
     */
    private static function validateRequiredFields($details) {
        $validator = Validator::make($details, [
            'name' => 'required',
            'fields' => 'array'
        ]);
        if($validator->fails()) throw new ValidationException($validator, "Missing required fields.", $validator->errors());
        return true;
    }

    /**
     * Notifies all form recipients about the new submission.
     * @param Submission $submission
     * @return void
     */
    public static function notifyRecipients(Submission $submission) {
        foreach($submission->form->recipients as $recipient) {
            NotificationsRepository::notifyFormRecipientForSubmission($recipient, $submission);
        }
    }

    public static function generateForm(string $description, Project $project, Form $form)
    {
        $prompt = "Generate a JSON array of fields for a form based on the following description:\n";
        $prompt .= $description . "\n";
        $prompt .= "For each field, include the following keys:\n";
        $prompt .= "- 'label': A string representing the label of the field\n";
        $prompt .= "- 'type': One of the following values: 'input', 'textarea', 'datepicker', 'dropdown', 'singleselect', 'multiselect', 'checkbox'\n";
        $prompt .= "- 'name': A string representing the name or identifier of the field\n";
        $prompt .= "- 'placeholder': A value initially displayed in te field\n";
        $prompt .= "Respond with only a JSON array of fields, nothing else.\n";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a form generator.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);
        $generatedForm = $response->json('choices.0.message.content');
        $formFields = json_decode($generatedForm, true);

        $formFields[] = [
            "label" => "Submit",
            "type" => "submit",
            "name" => "submit",
            "placeholder" => "Submit",
        ];

        $fieldsValue = self::generateFieldsValue($formFields);
        $output = ["rows" => $fieldsValue];

        if ($output) {
            FormsRepository::updateAttribute($form, 'fields', $output);
            FormsRepository::updateAttribute($form, 'prompt_message', $description);
        }

        return json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private static function generateFieldsValue(array $formFields)
    {
        $fieldsTemplate = require $_SERVER['DOCUMENT_ROOT'] . '/../config/fieldsTemplate.php';

        $rows = [];

        foreach ($formFields as $field) {
            $template = $fieldsTemplate[$field['type']] ?? [];
            $rows[] = [
                "columns" => [
                    [
                        "width" => "col-12",
                        "fields" => [
                            array_merge($template, [
                                "type" => $field["type"],
                                "title" => $field["label"],
                                "name" => $field["name"],
                                "id" => "{$field['name']}-field",
                                "placeholder" => $field["placeholder"],
                                "label" => $field["label"],
                                "value" => "",
                            ]),
                        ],
                    ],
                ],
            ];
        }

        return $rows;
    }


}