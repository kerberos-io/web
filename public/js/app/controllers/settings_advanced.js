define(["jquery", "app/controllers/event"], function($, event)
{
    $(function()
    {
        // When clicked on the expand button, we show the section
        // and alert the section it has been opened "changed".
        $("#machinery-settings div.open-section i").click(function(e)
        {
            // Show the section
            var section = $(this).parent().parent().next();
            section.toggle();

            // Revert the icon from expand to collapse or viceversa
            if($(this).hasClass("fa-arrow-circle-down"))
            {
                $(this).removeClass("fa-arrow-circle-down");
                $(this).addClass("fa-arrow-circle-up");
            }
            else
            {
                $(this).removeClass("fa-arrow-circle-up");
                $(this).addClass("fa-arrow-circle-down");
            }

            // Search for all items in section, that have to be
            // informed that the section openend. For example: hull selection
            // has to rerender points.
            var todo = section.find(".doSomethingOnChange");
            event.trigger("section.opened", todo);
        });

        // When changing dropdown, we make the other section visible
        $("#machinery-settings .dropdown select").change(changeSection);

        function changeSection(v)
        {
            // Show the section
            var section = $(this).parent().parent().next();

            // hide everything and show the selected one
            $.each(section.children(), function(key, value){
                $(value).css({"display":"none"});
                var todo = $(value).find(".doSomethingOnChange");
                event.trigger("section.closed", todo);
            });

            // show section with selected id
            $.each($(this).parent().find("select"), function(index, value)
            {
                var open = section.find("#" + $(this).val());
                $(open).css({"display":"table"});
                var todo = open.find(".doSomethingOnChange");
                event.trigger("section.opened", todo);
            });
        }

        // When clicked on the delete button, hide dropdown.
        $("#machinery-settings div.delete-dropdown i").click(deleteDropdown);

        function deleteDropdown(e)
        {
            var previous = $(this).parent().parent().find("select");
            $(this).parent().prev().remove();
            $(this).parent().remove();
            previous.change();
        }

        // When clicked on the delete button, hide dropdown.
        $("#machinery-settings div.add-dropdown i").click(function(e)
        {
            var selects = $(this).parent().parent().find("select");
            var numberOfSelects = selects.length;
            var last = selects.last();
            var clone = last.clone();

            var clone_name = clone.attr("name");
            clone_id = clone_name.split(":")[1];
            clone_id++;
            clone_name = clone_name.slice(0,-1) + clone_id;
            clone.attr("name", clone_name);
            clone.bind("change", changeSection);

            if(numberOfSelects > 1)
            {
                last = last.next();
            }

            clone.insertAfter(last);
            var trashIcon = $("<div>").addClass("icon delete-dropdown").append($("<i>").addClass("fa fa-trash-o"));
            trashIcon.find("i").bind("click", deleteDropdown);
            trashIcon.insertAfter(clone);
        });
    });
});
