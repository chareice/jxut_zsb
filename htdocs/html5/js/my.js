var Person = Class.create(
	initialize: function(first,last,city,country){
		this.first = first;
		this.last = last;
		this.city = city;
		this.country = country;
	},
	
	getFullName: function(){
		return (this.first+''+this.last).strip();
	},
	
	getDisplayName: function(){
		var result=this.getFullname();
		if(this.city||this.country){
			result +=' (';
				if(this.city){
					result +=this.city;
					if(this.country) result +=',';
				}
				result +=(this.country || '');
				result +=')'; 
			}
			return result;
	}
)