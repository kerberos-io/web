<?php namespace Repositories\ImageHandler;

interface ImageHandlerInterface
{
	/************************************
    *   Show last image that was taken.     
    */
	public function getLatestImage();

	/******************************************
    *   Show latest sequence that was taken.     
    */
	public function getLatestSequence();

	/************************************************************
    *   Get last hour of day: the last image of a specific day
    */
	public function getLastHourOfDay($day);

	/********************************
     *  Calculate the last x days
     */
	public function getDays($numberOfDays);

	/*******************************
     * Get all images
     */
	public function getImages();

	/****************************************
     *  Get images from a specific day
     */
	public function getImagesFromDay($day, $take, $page);

	/***********************************************
     *  Get images within a specific range of days
     */
	public function getImagesWithinRangeOfDays($startDay, $endDay, $take, $page);

	/************************************************
     *  Get a sequence of images from a specific day
     */
	public function getImagesSequenceFromDay($day, $page, $maximumTimeBetween);

	/*************************************************************
     *  Get a sequence of images from a specific day and starttime
     */
	public function getImagesSequenceFromDayAndStartTime($day, $page, $starttime, $maximumTimeBetween);
	public function getSequence($imagesTemp, $page, $maximumTimeBetween);

	/*****************************************************
     *  Statistics Area: show number of images each hour
     *  for the past x days.
     */
	public function getNumberOfImagesPerHourForLastDays($numberOfDays, $averageDays);
	public function countImagesPerHour($day);
	public function countAverageImagesPerHour($numberOfDays);

	/*****************************************************
     *  Count image per weekday and per instance
     */
	public function getNumberOfImagesPerWeekDayPerInstance($numberOfWeeks);

	/******************************************************
     *  Show number of images
     *  for the past x days. (used for the pie chart)
     */
	public function getNumberOfImagesPerDayForLastDays($numberOfDays, $averageDays);
	public function countImagesPerDay($day);
	public function countAverageImagesPerDay($numberOfDays);
}