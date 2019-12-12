// External Dependencies
import React, { Component } from 'react';


class CustomCtaLh extends Component {

    static slug = 'dicm_lh_cta';

    /**
     * All component inline styling.
     *
     * @since 1.0.0
     *
     * @return array
     */
    static css(props) {
        const utils         = window.ET_Builder.API.Utils;
        const additionalCss = [];

        // Process text-align value into style
        if (props.text_align) {
            additionalCss.push([{
                selector:    '%%order_class%% .typography-fields',
                declaration: `text-align: ${props.text_align};`,
            }]);
        }

        // Process font option into style
        if (props.select_font) {
            additionalCss.push([{
                selector:    '%%order_class%% .typography-fields',
                declaration: utils.setElementFont(props.select_font),
            }]);
        }

        // Process color preview color
        if (props.color) {
            additionalCss.push([{
                selector:    '%%order_class%% .colorpicker-preview.color',
                declaration: `background-color: ${props.color};`,
            }]);
        }

        // Process color preview color alpha
        if (props.color_alpha) {
            additionalCss.push([{
                selector:    '%%order_class%% .colorpicker-preview.color-alpha',
                declaration: `background-color: ${props.color_alpha};`,
            }]);
        }

        return additionalCss;
    }

    /**
     * Custom method to render button UI
     *
     * @return {string|React.Component}
     */
    _renderButton() {
        const props              = this.props;
        const utils              = window.ET_Builder.API.Utils;
        const buttonTarget       = 'on' === props.url_new_window ? '_blank' : '';
        const buttonIcon         = props.button_icon ? utils.processFontIcon(props.button_icon) : false;
        const buttonClassName    = {
            et_pb_button:             true,
            et_pb_custom_button_icon: props.button_icon,
        };

        if (! props.button_text || ! props.button_url) {
            return '';
        }

        return (
            <div className='et_pb_button_wrapper'>
              <a
                  className={utils.classnames(buttonClassName)}
                  href={props.button_url}
                  target={buttonTarget}
                  rel={utils.linkRel(props.button_rel)}
                  data-icon={buttonIcon}
              >
                  {props.button_text}
              </a>
            </div>
        );
    }

    /**
     * Render prop value. Some attribute values need to be parsed before can be displayed
     *
     * @return {string|React.Component|React.component[]}
     */
    _renderProp(value, fieldName, fieldType, renderSlug) {
        const utils      = window.ET_Builder.API.Utils;
        const _          = utils._;
        const orderClass = `${this.props.moduleInfo.type}_${this.props.moduleInfo.order}`;

        let output = '';

        if (! value) {
            return output;
        }

        switch (fieldType) {
            case 'options_list':
                value = utils.decodeOptionListValue(value);

                if (_.isArray(value)) {
                    output = value.map((option, index) => {
                        return (
                            <option key={`${orderClass}-${index}`} value={option.value}>{option.value}</option>
                        );
                    });
                }
                break;
            case 'options_list_checkbox':
                const checkboxName = `${orderClass}_${fieldName}`;

                value = utils.decodeOptionListValue(value);

                if (_.isArray(value)) {
                    output = value.map((option, index) => {
                        const checkboxID = `${checkboxName}_${index}`;
                        const isChecked  = 1 === option.checked;

                        return (
                            <span className="checkbox-wrap" key={`${orderClass}-${index}`}>
                <input type="checkbox" id={checkboxID} className="input" value={option.value} readOnly={true} checked={isChecked}/>
                <label htmlFor={checkboxID}><i></i>{option.value}</label>
              </span>
                        );
                    });
                }
                break;
            case 'options_list_radio':
                const radioName = `${orderClass}_${fieldName}`;

                value = utils.decodeOptionListValue(value);

                if (_.isArray(value)) {
                    output = value.map((option, index) => {
                        const radioId   = `${radioName}_radio_${index}`;
                        const isChecked = 1 === option.checked;

                        return (
                            <span key={`${orderClass}-${index}`} className="radio-wrap">
                <input type="radio" id={radioId} className="input" value={option.value} name={radioName} readOnly={true} checked={isChecked}/>
                <label htmlFor={radioId}><i></i>{option.value}</label>
              </span>
                        );
                    });
                }
                break;
            case 'select_fonticon':
                output = (
                    <span style={{fontFamily: '"ETmodules"', fontSize: 40}}>{utils.processFontIcon(value)}</span>
                );
                break;
            case 'upload_image':
                output = <img src={value} alt=''/>;
                break;
            default:
                output = value;
                break;
        }

        return output;
    }

    /**
     * Render component output
     *
     * @return {string|React.Component|React.component[]}
     */
    render() {
        const props = this.props;

        return (
            <div>
              <h2 className="dicm-title">{this.props.title}</h2>
            </div>
        );
    }
}

export default CustomCtaLh;
