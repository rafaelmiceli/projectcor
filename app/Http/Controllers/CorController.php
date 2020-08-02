<?php

/**
 * author: miceli.rafael.dario@gmail.com
 * date: 07/31/2020
 * COR Assesment: Alphabetic Soup
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CorRequest;

class CorController extends Controller
{
    /**
     * searching pattern 
     */
    private $pattern = 'OIE';
    
    /**
     * pattern string length
     */
    private $pattern_length = 0;
    
    /**
     * matrix's number of columns
     */
    private $ncol;
    
    /**
     * matrix's number of rows
     */
    private $nrow;
    
    /**
     * raw input data
     */
    private $input;
    
    /**
     * matrix from input data
     */
    private $matrix = [];

    /**
     * endpoint
     * iterates over earch cell, generating words in all directions
     * and counts pattern matches
     * @param Request $request
     * @return json
     */
    public function check(CorRequest $request)
    {
        $this->input = $request->all();
        $this->matrix = $this->input['data'];
        $this->nrow = count($this->matrix);
        $this->ncol = count($this->matrix[0]);
        $this->pattern = $this->input['pattern'];
        $this->pattern_length = strlen($this->pattern);
        
        $count = 0;
        $unique_words = [];
        for ($i=0; $i < $this->nrow; $i++) { 
            for ($j=0; $j < $this->ncol; $j++) {
                $words = $this->get_words_from_point($i, $j);
                $count_values = array_count_values($words);
                $count  += $this->count_matches($count_values);
            }
        }
        
        return response()->json([
            #divide by because each pattern is counted twice
            'count' => $count / 2
        ]);
    }

    /**
     * counts pattern matches
     * @param array $array counted words array
     * @return int count of matches
     */
    private function count_matches($array) {
        $pattern_reverse = strrev($this->pattern);
        $count = 0;
        $count += isset($array[$this->pattern])? $array[$this->pattern] : 0;
        $count += isset($array[$pattern_reverse])? $array[$pattern_reverse] : 0;
        return $count;
    }

    /**
     * get_words_from_point
     * @param int row number
     * @param int col number
     */
    private function get_words_from_point($r, $c) {

        return [ 
            $this->get_word_hr($r,$c),
            $this->get_word_hi($r,$c),
            $this->get_word_vd($r,$c),
            $this->get_word_vu($r,$c),
            $this->get_word_ul($r,$c),
            $this->get_word_ur($r,$c),
            $this->get_word_dl($r,$c),
            $this->get_word_dr($r,$c)
        ];
    }

    /**
     * returns a word from point towards down-right
     */
    private function get_word_dr($r,$c)
    {
        $word = [];
        for ($i=0; $i < $this->pattern_length; $i++) {
            $letter = $this->get_letter($r + $i, $c + $i);
            if(!empty($letter)) {
                $word[] = $letter;
            }
        }
        return implode('', $word);
    }

    /**
     * returns a word from point towards down-left
     */
    private function get_word_dl($r,$c)
    {
        $word = [];
        for ($i=0; $i < $this->pattern_length; $i++) {
            $letter = $this->get_letter($r + $i, $c - $i);
            if(!empty($letter)) {
                $word[] = $letter;
            }
        }
        return implode('', $word);
    }

    /**
     * returns a word from point towards up-right
     */
    private function get_word_ur($r,$c)
    {
        $word = [];
        for ($i=0; $i < $this->pattern_length; $i++) {
            $letter = $this->get_letter($r - $i, $c + $i);
            if(!empty($letter)) {
                $word[] = $letter;
            }
        }
        return implode('', $word);
    }

    /**
     * returns a word from point towards up-left
     */
    private function get_word_ul($r,$c)
    {
        $word = [];
        for ($i=0; $i < $this->pattern_length; $i++) {
            $letter = $this->get_letter($r - $i, $c - $i);
            if(!empty($letter)) {
                $word[] = $letter;
            }
        }
        return implode('', $word);
    }

    /**
     * returns a word from point towards up
     */
    private function get_word_vu($r,$c)
    {
        $word = [];
        for ($i=0; $i < $this->pattern_length; $i++) {
            $letter = $this->get_letter($r - $i, $c);
            if(!empty($letter)) {
                $word[] = $letter;
            }
        }
        return implode('', $word);
    }

    /**
     * returns a word from point towards down
     */
    private function get_word_vd($r,$c)
    {
        $word = [];
        for ($i=0; $i < $this->pattern_length; $i++) {
            $letter = $this->get_letter($r + $i, $c);
            if(!empty($letter)) {
                $word[] = $letter;
            }
        }
        return implode('', $word);
    }

    /**
     * returns a word from point towards right horizonal
     */
    private function get_word_hr($r,$c)
    {
        $word = [];
        for ($i=0; $i < $this->pattern_length; $i++) {
            $letter = $this->get_letter($r, $c + $i);
            if(!empty($letter)) {
                $word[] = $letter;
            }
        }
        return implode('', $word);
    }

    /**
     * returns a word from point towards left horizonal
     */
    private function get_word_hi($r,$c)
    {
        $word = [];
        for ($i=0; $i < $this->pattern_length; $i++) {
            $letter = $this->get_letter($r, $c - $i);
            if(!empty($letter)) {
                $word[] = $letter;
            }
        }
        return implode('', $word);
    }

    /**
     * return a letter from matrix
     * @param int row number
     * @param int col number
     * @return boolean|char vacal from matrix
     */
    private function get_letter($r, $c) {
        
        if(isset($this->matrix[$r][$c])) {
            return $this->matrix[$r][$c];
        }
        return false;
    }
}