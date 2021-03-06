<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://mgrid.mdnsolutions.com/license>.
 */

namespace Mgrid\Column\Filter\Render;

use Mgrid\Column\Filter\Render;

/**
 * Select filter type
 *
 * @since       0.0.1
 * @author      Renato Medina <medinadato@gmail.com>
 */
class Select extends Render\ARender implements Render\IRender
{

    /**
     *
     * @return string
     */
    public function render()
    {
        //adiciono primeira opcao como tudo
        $attributes = $this->getAttributes();
        
        $options = '<option value = "">-</option>';
        foreach ($attributes['multiOptions'] as $key => $value) {
            $selected = ($attributes['value'] == $key) ? 'selected="selected"' : '';
            $options .= '<option value = "' . $key . '" ' . $selected . '>' . $value . '</option>';
        }
        unset($attributes['multiOptions'], $attributes['value']);

        // set name
        $attributes['name'] = $attributes['id'] = 'mgrid[filter][' . $this->getFieldIndex() . ']';

        $select = '<select ';
        $select .= $this->generateHtmlOfAttributes($select, $attributes);
        $select .= ' />';

        $select .= $options . ' <select/>';

        return $select;
    }

    /**
     * 
     * @return type
     */
    public function getConditions()
    {
        return array();
    }

}