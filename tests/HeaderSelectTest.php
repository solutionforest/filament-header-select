<?php

use SolutionForest\FilamentHeaderSelect\Components\HeaderSelect;

it('can create a header select', function () {
    $select = HeaderSelect::make('test');
    
    expect($select->getName())->toBe('test');
});

it('can set label', function () {
    $select = HeaderSelect::make('test')
        ->label('Test Label');
    
    expect($select->getLabel())->toBe('Test Label');
});

it('can set options', function () {
    $options = ['key1' => 'Value 1', 'key2' => 'Value 2'];
    $select = HeaderSelect::make('test')
        ->options($options);
    
    expect($select->getOptions())->toBe($options);
});

it('can evaluate closure options', function () {
    $select = HeaderSelect::make('test')
        ->options(fn() => ['dynamic' => 'Dynamic Value']);
    
    expect($select->getOptions())->toBe(['dynamic' => 'Dynamic Value']);
});

it('handles visibility', function () {
    $select = HeaderSelect::make('test');
    expect($select->isVisible())->toBeTrue();
    
    $select->visible(false);
    expect($select->isVisible())->toBeFalse();
});

it('handles disabled state', function () {
    $select = HeaderSelect::make('test');
    expect($select->isDisabled())->toBeFalse();
    
    $select->disabled(true);
    expect($select->isDisabled())->toBeTrue();
});
