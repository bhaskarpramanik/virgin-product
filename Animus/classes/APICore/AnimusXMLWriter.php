<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusXMLWriter
 * AnimusXMLWriter extends PHP XMLWriter
 * Class to output XML structures.
 * Intended to be used for ATOM / RSS publish classes
 * and normal XML output
 * NOTE: This class can create new XML files but can't APPEND to existing files.
 * Documentation: http://php.net/manual/en/book.xmlwriter.php
 * @author bhaskarpramanik
 */
class AnimusXMLWriter extends XMLWriter{
    
    public function endAttribute() {
        return parent::endAttribute();
    }

    public function endCdata() {
        return parent::endCdata();
    }

    public function endComment() {
        return parent::endComment();
    }

    public function endDocument() {
        return parent::endDocument();
    }

    public function endDtd() {
        return parent::endDtd();
    }

    public function endDtdAttlist() {
        return parent::endDtdAttlist();
    }

    public function endDtdElement() {
        return parent::endDtdElement();
    }

    public function endDtdEntity() {
        return parent::endDtdEntity();
    }

    public function endElement() {
        return parent::endElement();
    }

    public function endPi() {
        return parent::endPi();
    }

    public function flush($empty = true) {
        parent::flush($empty);
    }

    public function fullEndElement() {
        return parent::fullEndElement();
    }

    public function openMemory() {
        return parent::openMemory();
    }

    public function openUri($uri) {
        return parent::openUri($uri);
    }

    public function outputMemory($flush = true) {
        return parent::outputMemory($flush);
    }

    public function setIndent($indent) {
        return parent::setIndent($indent);
    }

    public function setIndentString($indentString) {
        return parent::setIndentString($indentString);
    }

    public function startAttribute($name) {
        return parent::startAttribute($name);
    }

    public function startAttributeNs($prefix, $name, $uri) {
        return parent::startAttributeNs($prefix, $name, $uri);
    }

    public function startCdata() {
        return parent::startCdata();
    }

    public function startComment() {
        return parent::startComment();
    }

    public function startDocument($version = 1.0, $encoding = null, $standalone = null) {
        return parent::startDocument($version, $encoding, $standalone);
    }

    public function startDtd($qualifiedName, $publicId = null, $systemId = null) {
        return parent::startDtd($qualifiedName, $publicId, $systemId);
    }

    public function startDtdAttlist($name) {
        return parent::startDtdAttlist($name);
    }

    public function startDtdElement($qualifiedName) {
        return parent::startDtdElement($qualifiedName);
    }

    public function startDtdEntity($name, $isparam) {
        return parent::startDtdEntity($name, $isparam);
    }

    public function startElement($name) {
        return parent::startElement($name);
    }

    public function startElementNs($prefix, $name, $uri) {
        return parent::startElementNs($prefix, $name, $uri);
    }

    public function startPi($target) {
        return parent::startPi($target);
    }

    public function text($content) {
        return parent::text($content);
    }

    public function writeAttribute($name, $value) {
        return parent::writeAttribute($name, $value);
    }

    public function writeAttributeNs($prefix, $name, $uri, $content) {
        return parent::writeAttributeNs($prefix, $name, $uri, $content);
    }

    public function writeCdata($content) {
        return parent::writeCdata($content);
    }

    public function writeComment($content) {
        return parent::writeComment($content);
    }

    public function writeDtd($name, $publicId = null, $systemId = null, $subset = null) {
        return parent::writeDtd($name, $publicId, $systemId, $subset);
    }

    public function writeDtdAttlist($name, $content) {
        return parent::writeDtdAttlist($name, $content);
    }

    public function writeDtdElement($name, $content) {
        return parent::writeDtdElement($name, $content);
    }

    public function writeDtdEntity($name, $content, $pe, $pubid, $sysid, $ndataid) {
        return parent::writeDtdEntity($name, $content, $pe, $pubid, $sysid, $ndataid);
    }

    public function writeElement($name, $content = null) {
        return parent::writeElement($name, $content);
    }

    public function writeElementNs($prefix, $name, $uri, $content = null) {
        return parent::writeElementNs($prefix, $name, $uri, $content);
    }

    public function writePi($target, $content) {
        return parent::writePi($target, $content);
    }

    public function writeRaw($content) {
        return parent::writeRaw($content);
    }

}
