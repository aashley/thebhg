<table border="0" cellspacing="4" cellpadding="0" summary="Monthly calendar with links to each day's posts">
  <caption class="calendarhead">
    {$month_name}&nbsp;{$year}
  </caption>
  <tr>
  {section name="day_of_week" loop=$day_of_week_abbrevs}
    <th align="center"><span class="calendar">{$day_of_week_abbrevs[day_of_week]}</span></th>
  {/section}
  </tr>
  {section name="row" loop=$calendar}
    <tr>
      {section name="col" loop=$calendar[row]}
        {assign var="date" value=$calendar[row][col]}
          <td align="center">
        {if $date == $selected_date}
            <span class="calendar" style="font-weight: bold">
		{else}
            <span class="calendar">
		{/if}
        {if $date|date_format:"%m" == $month}
		  {if in_array ($date, $items) eq 1}
              <a href="{$date|date_format:$url_format}">
                {$date|date_format:"%e"}
              </a>
			{else}
                {$date|date_format:"%e"}
			{/if}		
        {else}
              &nbsp;
        {/if}
            </span>
          </td>
      {/section}
    </tr>
  {/section}
</table>
