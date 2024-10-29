/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/edit.element.js":
/*!*****************************!*\
  !*** ./src/edit.element.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _icons_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./icons.js */ "./src/icons.js");

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */






/* import { v4 as uuidv4 } from 'uuid'; */
/**
 * Icons
 */

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
function Edit(props) {
  const {
    attributes,
    setAttributes,
    blockProps,
    clientId,
    className
  } = props;
  const {
    selectedElement,
    textContent,
    textareaContent,
    selectOptions,
    radioOptions,
    checkOptions,
    elementLabel,
    elementID
  } = attributes;
  const getRandomNumber = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };
  if (!elementID) {
    setAttributes({
      elementID: getRandomNumber(10000, 10000000)
    });
  }
  const handleElementChange = newElement => {
    setAttributes({
      selectedElement: newElement
    });
  };
  const handleTextChange = newText => {
    setAttributes({
      textContent: newText
    });
  };
  const handleTextareaChange = newText => {
    setAttributes({
      textareaContent: newText
    });
  };
  const handleLabelChange = newText => {
    setAttributes({
      elementLabel: newText
    });
  };
  const handleIdChange = newText => {
    setAttributes({
      elementID: newText
    });
  };
  const handleSelectLabelChange = (newLabel, index) => {
    const updatedOptions = [...selectOptions];
    updatedOptions[index].label = newLabel;
    setAttributes({
      selectOptions: updatedOptions
    });
  };
  const handleRadioLabelChange = (newLabel, index) => {
    const updatedOptions = [...radioOptions];
    updatedOptions[index].label = newLabel;
    setAttributes({
      radioOptions: updatedOptions
    });
  };
  const handleCheckLabelChange = (newLabel, index) => {
    const updatedOptions = [...checkOptions];
    updatedOptions[index].label = newLabel;
    setAttributes({
      checkOptions: updatedOptions
    });
  };
  const addSelectOption = () => {
    setAttributes({
      selectOptions: [...selectOptions, {
        label: '',
        value: ''
      }]
    });
  };
  const deleteSelectOption = index => {
    const updatedOptions = [...selectOptions];
    updatedOptions.splice(index, 1);
    setAttributes({
      selectOptions: updatedOptions
    });
  };
  const addRadioOption = () => {
    setAttributes({
      radioOptions: [...radioOptions, {
        label: '',
        value: ''
      }]
    });
  };
  const addCheckOption = () => {
    setAttributes({
      checkOptions: [...checkOptions, {
        label: '',
        value: ''
      }]
    });
  };
  const deleteRadioOption = index => {
    const updatedOptions = [...radioOptions];
    updatedOptions.splice(index, 1);
    setAttributes({
      radioOptions: updatedOptions
    });
  };
  const deleteCheckOption = index => {
    const updatedOptions = [...checkOptions];
    updatedOptions.splice(index, 1);
    setAttributes({
      checkOptions: updatedOptions
    });
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
    title: "Block Settings",
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Label', 'momoacg'),
    value: elementLabel,
    onChange: handleLabelChange
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Element ID', 'momoacg'),
    value: elementID,
    onChange: handleIdChange
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.RadioControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Choose Element', 'momoacg'),
    selected: selectedElement,
    options: [{
      label: 'Text',
      value: 'text'
    }, {
      label: 'Select',
      value: 'select'
    }, {
      label: 'Radio',
      value: 'radio'
    }, {
      label: 'Checkbox',
      value: 'checkbox'
    }, {
      label: 'Textarea',
      value: 'textarea'
    }],
    onChange: handleElementChange
  }), selectedElement === 'text' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {
    label: "placeholder",
    value: textContent,
    onChange: handleTextChange
  }), selectedElement === 'select' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_4__.Fragment, null, selectOptions.map((option, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    key: `select-option-${index}`,
    style: {
      display: 'flex',
      alignItems: 'center'
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {
    label: `Option ${index + 1}`,
    value: option.label,
    onChange: newLabel => handleSelectLabelChange(newLabel, index)
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.IconButton, {
    isDestructive: true,
    onClick: () => deleteSelectOption(index),
    icon: "trash",
    style: {
      marginLeft: '10px'
    }
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
    variant: "primary",
    onClick: addSelectOption
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add Option', 'momoacg'))), selectedElement === 'radio' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, radioOptions.map((option, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    key: `radio-option-${index}`,
    style: {
      display: 'flex',
      alignItems: 'center'
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {
    label: `Option ${index + 1}`,
    value: option.label,
    onChange: newLabel => handleRadioLabelChange(newLabel, index)
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.IconButton, {
    isDestructive: true,
    onClick: () => deleteRadioOption(index),
    icon: "trash",
    style: {
      marginLeft: '10px'
    }
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
    variant: "primary",
    onClick: addRadioOption
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add Option', 'momoacg'))), selectedElement === 'checkbox' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, checkOptions.map((option, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    key: `check-option-${index}`,
    style: {
      display: 'flex',
      alignItems: 'center'
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {
    label: `Option ${index + 1}`,
    value: option.label,
    onChange: newLabel => handleCheckLabelChange(newLabel, index)
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.IconButton, {
    isDestructive: true,
    onClick: () => deleteCheckOption(index),
    icon: "trash",
    style: {
      marginLeft: '10px'
    }
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
    variant: "primary",
    onClick: addCheckOption
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add Option', 'momoacg'))), selectedElement === 'textarea' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Placeholder', 'momoacg'),
    value: textareaContent,
    onChange: handleTextareaChange
  })))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Placeholder, {
    icon: _icons_js__WEBPACK_IMPORTED_MODULE_5__["default"].content,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('MoMo Form Element', 'momoacg'),
    isColumnLayout: true
  }, selectedElement === 'text' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "momo-form-element-block"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, elementLabel), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "text",
    placeholder: textContent
  }))), selectedElement === 'select' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "momo-form-element-block"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, elementLabel), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("select", null, selectOptions.map((option, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
    key: `select-option-${index}`,
    value: option.value
  }, option.label)))), selectedElement === 'radio' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "momo-form-element-block"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, elementLabel), radioOptions.map((option, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "radio",
    id: `radio-option-${index}`,
    value: option.value
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    class: "momo-radio-label"
  }, option.label)))), selectedElement === 'checkbox' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "momo-form-element-block"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, elementLabel), checkOptions.map((option, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "checkbox",
    name: `check-option-${index}`,
    value: option.value
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    class: "momo-checkbox-label"
  }, option.label)))), selectedElement === 'textarea' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "momo-form-element-block"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, elementLabel), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("textarea", {
    cols: "5",
    placeholder: textareaContent
  }))))));
}

/***/ }),

/***/ "./src/edit.js":
/*!*********************!*\
  !*** ./src/edit.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./editor.scss */ "./src/editor.scss");
/* harmony import */ var _icons_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./icons.js */ "./src/icons.js");


/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */



/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Icons
 */

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
function Edit(props) {
  /*     const blockProps = useBlockProps(); */
  const ALLOWED_BLOCKS = ['core/paragraph', 'core/heading', 'core/columns', 'core/column', 'core/image', 'momo-acg-forms/momo-form-elements', 'momo-acg-forms/momo-form-submit', 'momo-acg-forms/momo-form-result'];
  const {
    attributes,
    setAttributes,
    blockProps,
    clientId,
    className
  } = props;
  const {
    header,
    subHeader
  } = attributes;
  const handleHeaderChange = newText => {
    setAttributes({
      header: newText
    });
  };
  const handleSubHeaderChange = newText => {
    setAttributes({
      subHeader: newText
    });
  };
  const customClassName = 'momo-acg-form-container-editor';
  const combinedClassNames = '${className} ${customClassName}';
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({}, blockProps, {
    className: combinedClassNames
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: "Block Settings",
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: "Header",
    value: header,
    onChange: handleHeaderChange
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Subheader', 'momoacg'),
    value: subHeader,
    onChange: handleSubHeaderChange
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Placeholder, {
    icon: _icons_js__WEBPACK_IMPORTED_MODULE_6__["default"].content,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('MoMo Form Container', 'momoacg'),
    instructions: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Please insert needed form element(s) along with result section.', 'momoacg'),
    isColumnLayout: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "momo-acg-ai-form-container"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("h3", null, header), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("h4", null, subHeader), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InnerBlocks, {
    allowedBlocks: ALLOWED_BLOCKS,
    parentClientId: clientId
  })))));
}

/***/ }),

/***/ "./src/edit.result.js":
/*!****************************!*\
  !*** ./src/edit.result.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _icons_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./icons.js */ "./src/icons.js");

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */



/**
 * Icons
 */

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
function Edit(props) {
  const {
    attributes,
    setAttributes,
    blockProps
  } = props;
  const {
    customPrompt,
    submitText
  } = attributes;
  /* let parentBlockObj = null;
  const parentBlocks = useSelect((select) => select('core/block-editor').getBlockParents(clientId));
  parentBlocks.forEach((parentId) => {
      const parentBlock = wp.data.select('core/block-editor').getBlock(parentId);
      if (parentBlock && parentBlock.name === 'momo-acg-forms/momo-form-container') {
        // Do something with the matching parent block
        console.log('Matching parent block found:', parentBlock);
        parentBlockObj = parentBlock;
      }
  });
  if (parentBlockObj && parentBlockObj.innerBlocks) {
      const childBlocks = parentBlockObj.innerBlocks;
       childBlocks.forEach((childBlock) => {
          if (childBlock.name === 'momo-acg-forms/momo-form-elements') {
          // Do something with the matching child block
          console.log('Matching Child Block:', childBlock);
          }
      });
  } */
  const onChangeCustomPrompt = newText => {
    setAttributes({
      customPrompt: newText
    });
  };
  const handleSubmitChange = newText => {
    setAttributes({
      submitText: newText
    });
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", blockProps, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: "Block Settings",
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.BaseControl, {
    help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('While creating a prompt you can use form element ID inside curly bracket to replace user input with prompt. For eg: <code>What is the capital of {text-control-country} ?</code>', 'momoacg')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Custom Prompt', 'momoacg'),
    value: customPrompt,
    onChange: onChangeCustomPrompt
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Submit Button Text', 'momoacg'),
    value: submitText,
    onChange: handleSubmitChange
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "momo-acg-ai-form-submit-bottom"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    id: "momo-generate-output-from-form",
    variant: "primary"
  }, submitText)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Placeholder, {
    icon: _icons_js__WEBPACK_IMPORTED_MODULE_4__["default"].content,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('MoMo Form Result', 'momoacg'),
    instructions: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('This is where your result will be printed. In Block Settings you can create your own custom prompt with the help of Form elements ID that you\'ve inserted inside the Form container', 'momoacg'),
    isColumnLayout: true
  }));
}

/***/ }),

/***/ "./src/icons.js":
/*!**********************!*\
  !*** ./src/icons.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const icons = {};
const styles = {
  fill: 'rgba(0, 0, 0, 1)'
};
icons.content = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "100",
  height: "100",
  viewBox: "0 0 100 100"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("circle", {
  cx: "50",
  cy: "50",
  r: "40",
  fill: "#FF6978"
}), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("text", {
  x: "24",
  y: "70",
  "font-size": "60",
  "font-weight": "bold",
  fill: "white"
}, "M"));
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (icons);

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./edit */ "./src/edit.js");
/* harmony import */ var _edit_element__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./edit.element */ "./src/edit.element.js");
/* harmony import */ var _save_element__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./save.element */ "./src/save.element.js");
/* harmony import */ var _edit_result__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./edit.result */ "./src/edit.result.js");
/* harmony import */ var _save_result__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./save.result */ "./src/save.result.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./save */ "./src/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./block.json */ "./src/block.json");
/* harmony import */ var _icons_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./icons.js */ "./src/icons.js");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */


/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Internal dependencies
 */








/**
 * Icons
 */


/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_9__.name, {
  title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('MoMo Form Container', 'momoacg'),
  icon: _icons_js__WEBPACK_IMPORTED_MODULE_10__["default"].content,
  category: 'common',
  attributes: {
    header: {
      type: 'string',
      default: ''
    },
    subHeader: {
      type: 'string',
      default: ''
    }
  },
  supports: {
    multiple: false // Allow only one instance of this block per post
  },

  templateLock: false,
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_3__["default"],
  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_8__["default"]
});
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)('momo-acg-forms/momo-form-elements', {
  title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('MoMo Form Elements', 'momoacg'),
  icon: _icons_js__WEBPACK_IMPORTED_MODULE_10__["default"].content,
  category: 'common',
  attributes: {
    selectedElement: {
      type: 'string',
      default: 'text'
    },
    textContent: {
      type: 'string',
      default: ''
    },
    textareaContent: {
      type: 'string',
      default: ''
    },
    selectOptions: {
      type: 'array',
      default: [{
        label: '',
        value: ''
      }]
    },
    radioOptions: {
      type: 'array',
      default: [{
        label: '',
        value: ''
      }]
    },
    checkOptions: {
      type: 'array',
      default: [{
        label: '',
        value: ''
      }]
    },
    elementLabel: {
      type: 'string',
      default: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Label', 'momoacg')
    },
    elementID: {
      type: 'string',
      default: ''
    }
  },
  edit: _edit_element__WEBPACK_IMPORTED_MODULE_4__["default"],
  save: _save_element__WEBPACK_IMPORTED_MODULE_5__["default"]
});
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)('momo-acg-forms/momo-form-result', {
  title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('MoMo Form Result', 'momoacg'),
  icon: _icons_js__WEBPACK_IMPORTED_MODULE_10__["default"].content,
  category: 'common',
  attributes: {
    customPrompt: {
      type: 'string',
      default: ''
    },
    submitText: {
      type: 'string',
      default: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Submit', 'momoacg')
    }
  },
  edit: _edit_result__WEBPACK_IMPORTED_MODULE_6__["default"],
  save: _save_result__WEBPACK_IMPORTED_MODULE_7__["default"]
});

/***/ }),

/***/ "./src/save.element.js":
/*!*****************************!*\
  !*** ./src/save.element.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ save)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
function save(_ref) {
  let {
    attributes
  } = _ref;
  const {
    selectedElement,
    textContent,
    textareaContent,
    selectOptions,
    radioOptions,
    checkOptions,
    elementLabel,
    elementID
  } = attributes;
  if (selectedElement === 'text') {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: "momo-form-element-block",
      "data-type": selectedElement
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, elementLabel), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "text",
      name: elementID,
      placeholder: textContent,
      "data-label": elementLabel
    })));
  }
  if (selectedElement === 'textarea') {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: "momo-form-element-block",
      "data-type": selectedElement
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, elementLabel), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("textarea", {
      name: elementID,
      placeholder: textareaContent,
      "data-label": elementLabel
    })));
  }
  if (selectedElement === 'select') {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: "momo-form-element-block",
      "data-type": selectedElement
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, elementLabel), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("select", {
      name: elementID,
      "data-label": elementLabel
    }, selectOptions.map((option, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
      key: `select-option-${index}`,
      value: option.label
    }, option.label))));
  }
  if (selectedElement === 'radio') {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: "momo-form-element-block",
      "data-type": selectedElement
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, elementLabel), radioOptions.map((option, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "radio",
      name: elementID,
      id: `radio-option-${index}`,
      value: option.label,
      "data-label": elementLabel
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
      class: "momo-radio-label"
    }, option.label))));
  }
  if (selectedElement === 'checkbox') {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: "momo-form-element-block",
      "data-type": selectedElement
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, elementLabel), checkOptions.map((option, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "checkbox",
      name: elementID,
      id: `check-option-${index}`,
      value: option.label,
      "data-label": elementLabel
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
      class: "momo-checkbox-label"
    }, option.label))));
  }
  return null;
}

/***/ }),

/***/ "./src/save.js":
/*!*********************!*\
  !*** ./src/save.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ save)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */


/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
function save(props) {
  console.log('yoyoma');
  const {
    attributes,
    setAttributes,
    blockProps,
    clientId,
    className
  } = props;
  const {
    header,
    subHeader
  } = attributes;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", blockProps, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "momo-acg-ai-form-container"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "momo-form-working"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", null, header), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h4", null, subHeader), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "momo-acg-form-hr"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "momo-acg-ai-innerblocks-fe"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InnerBlocks.Content, null))));
}

/***/ }),

/***/ "./src/save.result.js":
/*!****************************!*\
  !*** ./src/save.result.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ save)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
function save(props) {
  const {
    attributes,
    setAttributes,
    blockProps,
    clientId,
    className
  } = props;
  const {
    submitText,
    customPrompt
  } = attributes;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", blockProps, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "momo-acg-ai-form-submit-bottom"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    id: "momo-generate-output-from-form",
    "data-value": submitText,
    "data-prompt": customPrompt
  }, submitText)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "momo-forms-result-block"
  }));
}

/***/ }),

/***/ "./src/editor.scss":
/*!*************************!*\
  !*** ./src/editor.scss ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ _extends)
/* harmony export */ });
function _extends() {
  _extends = Object.assign ? Object.assign.bind() : function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  };
  return _extends.apply(this, arguments);
}

/***/ }),

/***/ "./src/block.json":
/*!************************!*\
  !*** ./src/block.json ***!
  \************************/
/***/ ((module) => {

module.exports = JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"momo-acg-forms/momo-form-container","version":"0.1.0","title":"MoMo Forms - Container","category":"widgets","icon":"smiley","description":"Container to hold all form elements.","supports":{"html":false},"textdomain":"momo-acg-forms","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}');

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkmomo_acg_forms"] = globalThis["webpackChunkmomo_acg_forms"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map