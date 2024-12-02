const formFields = [
    // Input field
    {
      title: "Full Name",
      type: "input",
      name: "name",
      id: "name-field",
      placeholder: "Enter your full name",
      required: true,
      category: "most-popular",
      label: "Name",
      value: "",
    },
    // Input field
    {
      title: "Email Address",
      type: "input",
      name: "email",
      id: "email-field",
      placeholder: "Enter your email",
      required: true,
      category: "most-popular",
      label: "Email",
      value: "",
      validation: "email",
    },
    // Textarea field
    {
      title: "Message",
      type: "textarea",
      name: "message",
      id: "message-field",
      placeholder: "Write your message here",
      required: true,
      category: "most-popular",
      label: "Message",
      value: "",
    },
    // Heading field
    {
      title: "Heading",
      type: "heading",
      name: "heading",
      id: "heading-field",
      content: "Heading",
      category: "headings-paragraphs",
      label: "Heading",
      level: 2,
    },
    // Paragraph field
    {
      title: "Paragraph",
      type: "paragraph",
      name: "paragraph",
      id: "paragraph-field",
      content: "Add your text here..",
      category: "headings-paragraphs",
      label: "Paragraph",
    },
    // Datepicker field
    {
      title: "Date Picker",
      type: "datepicker",
      name: "date",
      id: "dob-field",
      required: false,
      category: "simple-field",
      label: "Date of Birth",
      value: "",
    },
    // Spacer field
    {
      title: "Spacer",
      type: "spacer",
      height: "20",
      category: "layout",
    },
    // Divider field
    {
      title: "Divider",
      type: "divider",
      color: "#000",
      thickness: "3",
      width: "200",
      margin: "1rem 0",
      category: "layout",
    },
    // Submit Button
    {
      title: "Submit Button",
      type: "submit",
      name: "submit",
      id: "submit-button",
      label: "Submit",
      category: "simple-field",
    },
    // Dropdown field
    {
      title: "Dropdown",
      type: "dropdown",
      name: "dropdown-field",
      id: "dropdown-field",
      placeholder: "Select your option",
      required: true,
      category: "simple-field",
      label: "Choose option",
      value: "",
      options: [
        { label: "Option 1", value: "option-0-option-1" },
        { label: "Option 2", value: "option-1-option-2" },
        { label: "Option 3", value: "option-2-option-3" },
      ],
    },
    // Single Select field
    {
      title: "Single Select",
      type: "singleselect",
      name: "singleselect",
      id: "singleselect-field",
      required: true,
      category: "simple-field",
      label: "Choose option",
      value: "option-1",
      options: [
        { label: "Option 1", value: "option-0-option-1" },
        { label: "Option 2", value: "option-1-option-2" },
        { label: "Option 3", value: "option-2-option-3" },
      ],
    },
    // Multiselect field
    {
      title: "Multi Select",
      type: "multiselect",
      name: "multiselect",
      id: "multiselect-field",
      required: false,
      category: "simple-field",
      label: "Select option",
      value: [],
      options: [
        { label: "Option 1", value: "option-0-option-1" },
        { label: "Option 2", value: "option-1-option-2" },
        { label: "Option 3", value: "option-2-option-3" },
      ],
    },
    // Checkbox field
    {
      title: "Checkbox",
      type: "checkbox",
      name: "checkbox",
      id: "checkbox-field",
      required: true,
      category: "simple-field",
      label: "I agree to the terms and conditions",
      value: false,
    },
  ];
  
  export default formFields;
  