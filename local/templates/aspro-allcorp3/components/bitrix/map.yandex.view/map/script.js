window.BX_YMapAddPlacemark = function(map, arPlacemark, isClustered){
	if (null == map)
		return false;

	if(!arPlacemark.LAT || !arPlacemark.LON)
		return false;

	var props = {};

	
	if (null != arPlacemark.TEXT && arPlacemark.TEXT.length > 0)
	{
		var value_view = '';

		if (arPlacemark.TEXT.length > 0)
		{
			var rnpos = arPlacemark.TEXT.indexOf("\n");
			value_view = rnpos <= 0 ? arPlacemark.TEXT : arPlacemark.TEXT.substring(0, rnpos);
		}

		props.balloonContent = arPlacemark.TEXT.replace(/\n/g, '<br />');
		props.hintContent = value_view;
	}

	if (null != arPlacemark.HTML && arPlacemark.HTML.length > 0)
	{
		props.balloonContent = arPlacemark.HTML;
	}

	var option = {
		item: arPlacemark.ITEM_ID,
		// hideIconOnBalloonOpen: false,
		hasHint: false,
		// hasBalloon: false,
	};
	
	if(arAllcorp3Options['THEME']['DEFAULT_MAP_MARKET'] != 'Y')
	{
		var markerSVG = ymaps.templateLayoutFactory.createClass([
			'<svg width="38" height="48" class="marker dynamic" viewBox="0 0 38 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path class="fill-theme-svg" d="M31.7547 28.6615C33.7914 25.977 35 22.6296 35 19C35 10.1634 27.8366 3 19 3C10.1634 3 3 10.1634 3 19C3 27.8366 10.1634 35 19 35V43.061C19 44.0285 20.2369 44.4321 20.8075 43.6509L31.7555 28.6627L31.7547 28.6615Z" fill="#3761E9"/><path d="M1.5 19C1.5 28.1597 8.5372 35.6758 17.5 36.4366V43.061C17.5 45.4796 20.5922 46.4887 22.0188 44.5357L32.9668 29.5474L33.0099 29.4884C33.0974 29.3717 33.1834 29.2539 33.2681 29.1349L33.5968 28.6849L33.5871 28.6709C35.4274 25.9001 36.5 22.5736 36.5 19C36.5 9.33502 28.665 1.5 19 1.5C9.33502 1.5 1.5 9.33502 1.5 19Z" stroke="white" stroke-opacity="0.5" stroke-width="3"/><circle cx="19" cy="19" r="10" fill="white"/></svg>'
		].join(''));

		option.iconImageSize = [38, 48];
		option.iconLayout = markerSVG;
	}
	
	var obPlacemark = new ymaps.Placemark(
		[arPlacemark.LAT, arPlacemark.LON],
		props,
		option,
		{balloonCloseButton: true}
	);

	if(!isClustered) { map.geoObjects.add(obPlacemark); }

	return obPlacemark;
}

if (!window.BX_YMapAddPolyline)
{
	window.BX_YMapAddPolyline = function(map, arPolyline)
	{
		if (null == map)
			return false;

		if (null != arPolyline.POINTS && arPolyline.POINTS.length > 1)
		{
			var arPoints = [];
			for (var i = 0, len = arPolyline.POINTS.length; i < len; i++)
			{
				arPoints.push([arPolyline.POINTS[i].LAT, arPolyline.POINTS[i].LON]);
			}
		}
		else
		{
			return false;
		}

		var obParams = {clickable: true};
		if (null != arPolyline.STYLE)
		{
			obParams.strokeColor = arPolyline.STYLE.strokeColor;
			obParams.strokeWidth = arPolyline.STYLE.strokeWidth;
		}
		var obPolyline = new ymaps.Polyline(
			arPoints, {balloonContent: arPolyline.TITLE}, obParams
		);

		map.geoObjects.add(obPolyline);

		return obPolyline;
	}
}