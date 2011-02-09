/**
 * Accordion Effect for Script.aculo.us
 * Created by Lucas van Dijk
 * http://www.return1.net
 *
 * Copyright 2007 by Lucas van Dijk
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 */

var Accordion = Class.create();

Accordion.prototype = 
{
	initialize: function(handles, bodys, options) 
	{
		this.options = this._set_options(options);		
		this.headers = $$(handles);
		this.bodys = $$(bodys);
		
		if(this.bodys.length != this.headers.length)
		{
			throw Error('Number of headers/bodys does not match!');
		}
		
		for(var i = 0; i < this.headers.length; i++)
		{		
			Event.observe(this.headers[i], this.options.event_trigger, this.show.bind(this, i));			
			this.headers[i].style.cursor = "pointer";
			
			this.bodys[i].style.display = "none";
		}
		
		this.bodys[this.options.default_open].id = "visible";
		
		this.show(this.options.default_open, true);
	},

	show: function(index, force) 
	{		
		if ((index >= this.length) || (index < 0)) 
		{
			throw Error('Index out of range');
		}
		
		if (this.bodys[index].id == 'visible')
		{			 					
			if (typeof force == "boolean") 
			{						
				this.options.OnStart(index, this.bodys[index]);
								
				// Force display the visible object				
				for(var i = 0; i < this.bodys.length; i++)
				{
					if(this.bodys[i].style.display != 'none' && i != index)
					{
						new Effect.BlindUp(this.bodys[i]);
					}
				}
				
				new Effect.BlindDown(this.bodys[index]);
			}
		}
		else
		{		
			this.options.OnStart(index, this.bodys[index]);
						
			// Normal change
			new Effect.Parallel(
				[
					new Effect.Fade($('visible')),				
					new Effect.BlindUp($('visible')),
					new Effect.BlindDown(this.bodys[index]),
					new Effect.Appear(this.bodys[index])
				], {
					duration: this.options.duration
				}
			);
	
			$('visible').id = "";
			this.bodys[index].id = "visible";
		}
		
		this.options.OnFinish(index, this.bodys[index]);
	},
	
	_default_options: 
	{
		duration: 0.3,
		event_trigger: 'click',
		OnStart: function() { },
		OnFinish: function() { },
		default_open: 0
	},
	
	_set_options: function(options)
	{
		if(typeof options != "undefined")
		{		
			var result = [];
			for(option in this._default_options)
			{
				if(typeof options[option] == "undefined")
				{
					result[option] = this._default_options[option];
				}
				else
				{
					result[option] = options[option];
				}
			}
		
			return result;
		}
		else
		{
			return this._default_options;
		}
	}		
};

Effect.Accordion = Accordion;